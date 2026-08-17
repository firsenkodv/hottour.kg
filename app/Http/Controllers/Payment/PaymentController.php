<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use Domain\Payment\ViewModels\PaymentViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pagePayment(): View
    {
        $user = auth()->user();
        $payments = PaymentViewModel::make()->userPayments($user->id, true);

        return view('dashboard.payment.payment',
            [
                'user' => $user,
                'payments' => $payments,
            ]);

    }

    public function paymentCustomAmount(PaymentRequest $request)
    {

        $formUrl = PaymentViewModel::make()->customAmount($request);
        if ($formUrl) {
            return redirect($formUrl);
        }
        flash()->alert(config('message_flash.alert.bereke_error'));
        return redirect()->back();

    }

    public function returnPaymentOrder(Request $request)
    {

        $result = PaymentViewModel::make()->returnOrder($request);

        if ($result['order_status'] === 2) {

            /** Запишем результат */
            $r = PaymentViewModel::make()->saveOrder($result);
            flash()->info(config('message_flash.info.bereke_info'));
            return redirect()->route('page.payment');
        }
        flash()->alert(config('message_flash.alert.bereke_status_error'));
        return redirect()->route('page.payment');    }

}
