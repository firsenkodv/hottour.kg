<?php

namespace App\Listeners;

use App\Events\MessageAdminCreateUserEvent;
use App\Mail\SendMails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MessageAdminCreateUserHandlerListener
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
     * сообщение админу о регистрации user-а
     */
    public function handle(MessageAdminCreateUserEvent $event): void
    {
        $user = $event->user;
        $sendMail =  new SendMails();
        $sendMail->send_to_Admin($user);
    }
}
