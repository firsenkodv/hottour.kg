<?php

namespace App\Listeners;

use App\Events\ResetPasswordEvent;
use App\Mail\SendMails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ResetPasswordHandlerListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * сообщение user-у о сбросе пароля
     */
    public function handle(ResetPasswordEvent $event): void
    {
        settype($data, "array");

        $data['token'] = $event->token;
        $data['email'] = $event->email;

        $sendMail =  new SendMails();
        $sendMail->send_to_ResetPassword($data);
    }
}
