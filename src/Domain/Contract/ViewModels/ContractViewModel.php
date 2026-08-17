<?php

namespace Domain\Contract\ViewModels;

use App\Models\CityAirport;
use App\Models\Contract;
use App\Models\ContractFood;
use App\Models\ContractRoom;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Support\Traits\Makeable;

class ContractViewModel
{
    use Makeable;

    private const PASSPORT_FIELDS = ['passport', 'passport_issued_at', 'passport_issued_by', 'inn'];

    public function contracts(): LengthAwarePaginator
    {
        return Contract::query()
            ->with(['user', 'hotel'])
            ->when(
                role(auth()->id()) === 'manager',
                fn ($query) => $query->whereHas('user', fn ($q) => $q->where('user_id', auth()->id()))
            )
            ->orderByDesc('created_at')
            ->paginate(20);
    }

    public function userContracts(): LengthAwarePaginator
    {
        return Contract::query()
            ->with(['hotel'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(20);
    }

    public function contractData(Contract $contract): array
    {
        $contract->loadMissing(['user', 'hotel', 'room', 'food']);

        return [
            'id'              => $contract->id,
            'contract_number' => $contract->contract_number,
            'title'           => $contract->title,
            'user_id'         => $contract->user_id,
            'user_name'       => $contract->user?->name,
            'city_departure'  => $contract->city_departure,
            'city_arrival'    => $contract->city_arrival,
            'date_departure'  => $contract->date_departure?->format('Y-m-d'),
            'date_arrival'    => $contract->date_arrival?->format('Y-m-d'),
            'days_count'      => $contract->days_count,
            'hotel_id'        => $contract->hotel_id,
            'hotel_name'      => $contract->hotel?->title,
            'hotel_custom'    => $contract->hotel_custom,
            'tour_price'      => $contract->tour_price,
            'framework_url'   => $contract->framework_url,
            'is_signed'       => $contract->is_signed,
            'public_url'      => $contract->public_url,
            'contract_room_id'       => $contract->contract_room_id,
            'contract_food_id'       => $contract->contract_food_id,
            'people'                 => $contract->people,
            'transfer'                => $contract->transfer,
            'excursion_program'       => $contract->excursion_program,
            'russian_speaking_guide'  => $contract->russian_speaking_guide,
            'visa_support'            => $contract->visa_support,
            'medical_support'         => $contract->medical_support,
            'passport'                => $contract->passport,
            'passport_issued_at'      => $contract->passport_issued_at,
            'passport_issued_by'      => $contract->passport_issued_by,
            'inn'                     => $contract->inn,
        ];
    }

    public function store(array $data): Contract
    {
        $contract = Contract::create($data);

        $this->syncUserPassportData($contract->user_id, $data);

        return $contract;
    }

    public function update(Contract $contract, array $data): void
    {
        $contract->update($data);

        $this->syncUserPassportData($contract->user_id, $data);
    }

    private function syncUserPassportData(int $userId, array $data): void
    {
        User::where('id', $userId)->update(Arr::only($data, self::PASSPORT_FIELDS));
    }

    public function searchHotels(string $q): Collection
    {
        return Hotel::where('title', 'like', '%' . $q . '%')
            ->orderBy('title')
            ->limit(15)
            ->get(['id', 'title']);
    }

    public function searchUsers(string $q): Collection
    {
        return User::where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%')
                    ->orWhere('email', 'like', '%' . $q . '%')
                    ->orWhere('phone', 'like', '%' . $q . '%');
            })
            ->when(
                role(auth()->id()) === 'manager',
                fn ($query) => $query->where('user_id', auth()->id())
            )
            ->orderBy('name')
            ->limit(15)
            ->get(['id', 'name', 'email', 'phone', 'passport', 'passport_issued_at', 'passport_issued_by', 'inn']);
    }

    public function searchCities(string $q): Collection
    {
        return CityAirport::where('city_ru', 'like', '%' . $q . '%')
            ->orWhere('city_en', 'like', '%' . $q . '%')
            ->orWhere('country_ru', 'like', '%' . $q . '%')
            ->orderByDesc('population')
            ->limit(15)
            ->get(['id', 'city_ru', 'country_ru']);
    }

    public function contractRooms(): Collection
    {
        return ContractRoom::orderBy('title')->get();
    }

    public function contractFoods(): Collection
    {
        return ContractFood::orderBy('title')->get();
    }
}
