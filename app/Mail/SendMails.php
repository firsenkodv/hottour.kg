<?php

namespace App\Mail;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SendMails
{
    /**
     * auth
     */
    public function send_to_User($user):void
    {
        $view = 'html.email.auth.register_user';
        $subject =  'Создан аккаунт. Данные для входа';

        Mail::send($view, ['user' => $user],  function ($message) use ($user, $subject){
            $message->to($user->email, 'Admin')->subject($subject);
        });
    }

    public function send_to_Admin($user):void
    {
        $view = 'html.email.auth.register_message_admin';
        $subject =  'Создан аккаунт -  '. $user->email;

        Mail::send($view, ['user' => $user],  function ($message) use ($user, $subject){
            $message->to(config('app.mail_zakaz'), 'Admin')->subject($subject);
        });
    }
    public function send_to_ResetPassword($data):void
    {
        $view = 'html.email.auth.reset_password';
        $subject =  'Оповещение о сбросе пароля';

        Mail::send($view, ['data' => $data],  function ($message) use ($data, $subject){
            $message->to($data['email'], 'Admin')->subject($subject);
        });
    }

    // send_to_ResetPassword

    /**
     * end auth
     */
    public function sendOrderCall($data):void
    {
        $view = 'html.email.order_call';
        $subject = 'Заказ обратного звонка ' . $data['phone'];

        Mail::send($view, ['data' => $data],  function ($message) use ($subject){
            $message->to(config('app.mail_zakaz'), 'Admin')->subject($subject);
        });
    }

    public function sendOrderMini($data):void
    {
        $view = 'html.email.order_mini';
        $subject = 'Заявка с сайта ' . $data['phone'];

        Mail::send($view, ['data' => $data],  function ($message) use ($subject){
            $message->to(config('app.mail_zakaz'), 'Admin')->subject($subject);
        });
    }

    public function sendCalc($data):void
    {
        $view = 'html.email.calc';
        $subject = 'Заявка с кредитного калькулятора';

        Mail::send($view, ['data' => $data],  function ($message) use ($subject){
            $message->to(config('app.mail_zakaz'), 'Admin')->subject($subject);
        });
    }

    public function sendPickTours($data):void
    {
        $view = 'html.email.pick_tours';
        $subject = 'Заявка с сайта на подбор тура';

        Mail::send($view, ['data' => $data],  function ($message) use ($subject){
            $message->to(config('app.mail_zakaz'), 'Admin')->subject($subject);
        });
    }

    public function sendCertificateOrder($data):void
    {
        $view = 'html.email.certificate_order';
        $subject = 'Заявка с сайта на подарочный сертификат';

        Mail::send($view, ['data' => $data],  function ($message) use ($subject){
            $message->to(config('app.mail_zakaz'), 'Admin')->subject($subject);
        });
    }

    public function sendPickSubscription($data):void
    {
        $view = 'html.email.pick_subscription';
        $subject = 'Подписка на рассылку';

        Mail::send($view, ['data' => $data],  function ($message) use ($subject){
            $message->to(config('app.mail_zakaz'), 'Admin')->subject($subject);
        });
    }

    public function sendPickResponce($data):void
    {
        $view = 'html.email.pick_responce';
        $subject = 'Отзыв на сайте';

        Mail::send($view, ['data' => $data],  function ($message) use ($subject){
            $message->to(config('app.mail_zakaz'), 'Admin')->subject($subject);
        });
    }

    public function sendSendOrderTour($data):void
    {
        $view = 'html.email.send_order_tour';
        $subject = 'Заявка с сайта на выбранный тур';

        Mail::send($view, ['data' => $data],  function ($message) use ($subject){
            $message->to(config('app.mail_zakaz'), 'Admin')->subject($subject);
        });
    }

    public function sendSignatureMessage($data):void
    {
        $view = 'html.email.signature';
        $subject = 'Договор подписан on-line';

        Mail::send($view, ['data' => $data],  function ($message) use ($subject){
            $message->to(config('app.mail_admin'), 'Admin')->subject($subject);
        });
    }

    public function sendSystemMessage($data):void
    {
        $view = 'html.email.system_admin_email';
        $subject = 'Системное сообщение';

        Mail::send($view, ['data' => $data],  function ($message) use ($subject){
            $message->to(config('app.mail_admin'), 'Admin')->subject($subject);
        });
    }

    public function sendTestSystemMessage($data = null):void
    {

        $view = 'html.email.system_admin_testemail';
        $subject = 'Тестовое системное сообщение';

        Mail::send($view, ['data' => ($data)?:''],  function ($message) use ($subject){
            $message->to(config('app.mail_admin'), 'Admin')->subject($subject);
        });
    }

}
