<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\User;
use Domain\Contract\ViewModels\ContractViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function __construct(private readonly ContractViewModel $vm) {}

    /**
     * Менеджер видит и может редактировать только договоры своих закреплённых клиентов.
     */
    private function abortIfManagerNotOwner(Contract $contract): void
    {
        if (role(auth()->id()) === 'manager') {
            abort_if($contract->user?->user_id !== auth()->id(), 403);
        }
    }

    /**
     * Менеджер может создавать/переносить договор только на своих закреплённых клиентов.
     */
    private function managerUserRule(): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail): void {
            if (role(auth()->id()) === 'manager'
                && ! User::where('id', $value)->where('user_id', auth()->id())->exists()) {
                $fail('Вы можете оформлять договоры только для своих закреплённых пользователей.');
            }
        };
    }

    public function index(): View
    {
        return view('dashboard.contracts.contracts', [
            'user'          => auth()->user(),
            'contracts'     => $this->vm->contracts(),
            'contractRooms' => $this->vm->contractRooms(),
            'contractFoods' => $this->vm->contractFoods(),
        ]);
    }

    public function searchHotels(Request $request): JsonResponse
    {
        $q = trim($request->input('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        return response()->json($this->vm->searchHotels($q));
    }

    public function searchUsers(Request $request): JsonResponse
    {
        $q = trim($request->input('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        return response()->json($this->vm->searchUsers($q));
    }

    public function searchCities(Request $request): JsonResponse
    {
        $q = trim($request->input('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        return response()->json($this->vm->searchCities($q));
    }

    public function show(Contract $contract): JsonResponse
    {
        $this->abortIfManagerNotOwner($contract);

        return response()->json($this->vm->contractData($contract));
    }

    public function update(Request $request, Contract $contract): JsonResponse
    {
        $this->abortIfManagerNotOwner($contract);

        if ($contract->is_signed) {
            return response()->json(['error' => ['contract' => ['Нельзя редактировать подписанный договор.']]], 422);
        }

        $request->validate([
            'title'          => 'nullable|string|max:255',
            'user_id'        => ['required', 'exists:users,id', $this->managerUserRule()],
            'city_departure' => 'nullable|string|max:255',
            'city_arrival'   => 'nullable|string|max:255',
            'date_departure' => 'required|date',
            'date_arrival'   => 'required|date|after_or_equal:date_departure',
            'days_count'     => 'required|integer|min:1',
            'hotel_id'       => 'nullable|exists:hotels,id|required_without:hotel_custom',
            'hotel_custom'   => 'nullable|string|max:255',
            'tour_price'     => 'required|integer|min:0',
            'framework_url'  => 'nullable|string|max:500',
            'contract_room_id'       => 'nullable|exists:contract_rooms,id',
            'contract_food_id'       => 'nullable|exists:contract_foods,id',
            'people'                 => 'nullable|array',
            'people.adults'          => 'nullable|array',
            'people.adults.*.fio'    => 'nullable|string|max:255',
            'people.children'        => 'nullable|array',
            'people.children.*.fio'  => 'nullable|string|max:255',
            'people.children.*.age'  => 'nullable|string|max:10',
            'transfer'                => 'nullable|in:yes,no',
            'excursion_program'       => 'nullable|in:yes,no',
            'russian_speaking_guide'  => 'nullable|in:yes,no',
            'visa_support'            => 'nullable|in:yes,no',
            'medical_support'         => 'nullable|in:yes,no',
            'passport'                => 'nullable|string|max:50',
            'passport_issued_at'      => 'nullable|string|max:50',
            'passport_issued_by'      => 'nullable|string|max:255',
            'inn'                     => 'nullable|string|max:50',
        ]);

        $this->vm->update($contract, $request->only([
            'title', 'user_id', 'city_departure', 'city_arrival',
            'date_departure', 'date_arrival', 'days_count',
            'hotel_id', 'hotel_custom', 'tour_price', 'framework_url',
            'contract_room_id', 'contract_food_id', 'people',
            'transfer', 'excursion_program', 'russian_speaking_guide',
            'visa_support', 'medical_support',
            'passport', 'passport_issued_at', 'passport_issued_by', 'inn',
        ]));

        return response()->json(['success' => true, 'public_url' => $contract->public_url]);
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'title'          => 'nullable|string|max:255',
            'user_id'        => ['required', 'exists:users,id', $this->managerUserRule()],
            'city_departure' => 'nullable|string|max:255',
            'city_arrival'   => 'nullable|string|max:255',
            'date_departure' => 'required|date',
            'date_arrival'   => 'required|date|after_or_equal:date_departure',
            'days_count'     => 'required|integer|min:1',
            'hotel_id'       => 'nullable|exists:hotels,id|required_without:hotel_custom',
            'hotel_custom'   => 'nullable|string|max:255',
            'tour_price'     => 'required|integer|min:0',
            'framework_url'  => 'nullable|string|max:500',
            'contract_room_id'       => 'nullable|exists:contract_rooms,id',
            'contract_food_id'       => 'nullable|exists:contract_foods,id',
            'people'                 => 'nullable|array',
            'people.adults'          => 'nullable|array',
            'people.adults.*.fio'    => 'nullable|string|max:255',
            'people.children'        => 'nullable|array',
            'people.children.*.fio'  => 'nullable|string|max:255',
            'people.children.*.age'  => 'nullable|string|max:10',
            'transfer'                => 'nullable|in:yes,no',
            'excursion_program'       => 'nullable|in:yes,no',
            'russian_speaking_guide'  => 'nullable|in:yes,no',
            'visa_support'            => 'nullable|in:yes,no',
            'medical_support'         => 'nullable|in:yes,no',
            'passport'                => 'nullable|string|max:50',
            'passport_issued_at'      => 'nullable|string|max:50',
            'passport_issued_by'      => 'nullable|string|max:255',
            'inn'                     => 'nullable|string|max:50',
        ]);

        $contract = $this->vm->store($request->only([
            'title', 'user_id', 'city_departure', 'city_arrival',
            'date_departure', 'date_arrival', 'days_count',
            'hotel_id', 'hotel_custom', 'tour_price', 'framework_url',
            'contract_room_id', 'contract_food_id', 'people',
            'transfer', 'excursion_program', 'russian_speaking_guide',
            'visa_support', 'medical_support',
            'passport', 'passport_issued_at', 'passport_issued_by', 'inn',
        ]));

        flash()->info('Договор успешно создан.');

        if ($request->ajax()) {
            return response()->json(['success' => true, 'public_url' => $contract->public_url]);
        }

        return redirect()->route('page.contracts');
    }
}
