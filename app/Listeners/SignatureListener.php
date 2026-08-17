<?php

namespace App\Listeners;

use App\Events\SignatureEvent;
use App\Events\SystemMessageEvent;
use App\Mail\SendMails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SignatureListener
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
     * сообщение user, о расчете в кредитном калькуляторе
     */
    public function handle(SignatureEvent $event): void
    {

        $data['contract'] = $event->request['contract'];
        $data['name'] = $event->request['name'];
        $data['email'] = $event->request['email'];
        $data['phone'] = $event->request['phone'];
        $data['date'] = $event->request['date'];

        $sendMail =  new SendMails();
        $sendMail->sendSignatureMessage($data);

    }
}
