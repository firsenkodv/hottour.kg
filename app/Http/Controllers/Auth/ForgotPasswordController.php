<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends Controller
{

    public function page()
    {
        return view('auth.forgot-password');
    }

    public function handle(ForgotPasswordFormRequest $request):RedirectResponse
    {


        $status = Password::sendResetLink(
            $request->only('email')
        );

        /**
         * Событие отправка сообщения опроеделено в моделе User!!!
         * !!!!!!!!!!!!! ------------------------ !!!!!!!!!!!!!!!!
         * Зайди в модель!
         */


        if($status === Password::RESET_LINK_SENT) {
            flash()->info(config('message_flash.info.mess') . '<p>' . __($status) . '</p>');
            return  back();
        }

        return back()->withErrors(['email' => __($status)]);
    }




}
