<?php

namespace App\Listeners;

use App\Events\CreateUserEvent;
use App\Mail\SendMails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserHandlerListener
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
     * сообщение user о СВОЕЙ  регистрации
     */
    public function handle(CreateUserEvent $event): void
    {

                $user = $event->user;
                $sendMail =  new SendMails();
                $sendMail->send_to_User($user);

    }
}
