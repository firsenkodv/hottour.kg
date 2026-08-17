<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Domain\Contract\ViewModels\ContractViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class UserContractController extends Controller
{
    public function __construct(private readonly ContractViewModel $vm) {}

    public function index(): View
    {
        return view('dashboard.contracts.user_contracts', [
            'user'      => auth()->user(),
            'contracts' => $this->vm->userContracts(),
        ]);
    }

    public function show(Contract $contract): JsonResponse
    {
        abort_if($contract->user_id !== auth()->id(), 403);

        return response()->json($this->vm->contractData($contract));
    }
}
