<?php

namespace App\Listeners;

use App\Events\OrderMiniEvent;
use App\Mail\SendMails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderMiniHandlerListener
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
    public function handle(OrderMiniEvent $event): void
    {
        $data['name'] = $event->request->name;
        $data['phone'] = $event->request->phone;
        $data['email'] = $event->request->email;
        $data['url'] = $event->request->url;

        $sendMail =  new SendMails();
        $sendMail->sendOrderMini($data);

    }
}
