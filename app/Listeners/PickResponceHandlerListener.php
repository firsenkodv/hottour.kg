<?php

namespace App\Listeners;

use App\Events\PickResponceEvent;
use App\Mail\SendMails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PickResponceHandlerListener
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
     * сообщение user-а, о том, нужно подобрать тур
     */
    public function handle(PickResponceEvent $event): void
    {
        $data['name'] = $event->request->name;
        $data['responce'] = strip_tags($event->request->responce);
        $data['email'] = $event->request->email;
        $data['url'] = $event->request->url;

        $sendMail =  new SendMails();
        $sendMail->sendPickResponce($data);

    }
}
