<?php

namespace App\Listeners;

use App\Events\PickResponceEvent;
use App\Events\PickSubscriptionEvent;
use App\Mail\SendMails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PickSubscriptionHandlerListener
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
    public function handle(PickSubscriptionEvent $event): void
    {
        $data['name'] = $event->request->name;
        $data['phone'] = $event->request->phone;
        $data['sity'] = sity($event->request->sity);
        $data['email'] = $event->request->email;
        $data['country'] = ($event->request->country)?:'';
        $data['url'] = $event->request->url;

        $sendMail =  new SendMails();
        $sendMail->sendPickSubscription($data);

    }
}
