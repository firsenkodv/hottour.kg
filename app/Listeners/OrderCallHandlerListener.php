<?php

namespace App\Listeners;

use App\Events\OrderCallEvent;
use App\Mail\SendMails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCallHandlerListener
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
     * сообщение user, о том, нужно поззвонить (заказ звонка)
     */
    public function handle(OrderCallEvent $event): void
    {
        $data['phone'] = $event->request->phone;
        $data['sity'] = sity($event->request->sity);
        $data['url'] = $event->request->url;

        $sendMail =  new SendMails();
        $sendMail->sendOrderCall($data);

    }
}
