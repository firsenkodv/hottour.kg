<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class PublicContractController extends Controller
{
    public function show(string $token): View
    {
        $contract = Contract::with(['user', 'hotel', 'room', 'food'])
            ->where('public_token', $token)
            ->firstOrFail();

        return view('public.contract', compact('contract', 'token'));
    }

    public function sign(string $token, Request $request): JsonResponse
    {
        $contract = Contract::where('public_token', $token)
            ->where('is_signed', false)
            ->firstOrFail();

        $contract->update(['is_signed' => true]);

        return response()->json(['signed' => true]);
    }
}
