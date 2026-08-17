<?php

namespace App\Listeners;

use App\Events\PickTourEvent;
use App\Events\SendOrderTourEvent;
use App\Mail\SendMails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderTourHandlerListener
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
    public function handle(SendOrderTourEvent $event): void
    {
        $data['name'] = $event->request->name;
        $data['phone'] = $event->request->phone;
        $data['email'] = $event->request->email;

        $data['country'] = ($event->request->country)?:'';
        $data['hotel'] = ($event->request->hotel)?:'';
        $data['mealrussian'] = ($event->request->mealrussian)?:'';
        $data['sity'] = ($event->request->sity)?:'';
        $data['from'] = ($event->request->from)?:'';
        $data['to'] = ($event->request->to)?:'';
        $data['nights'] = ($event->request->nights)?:'';
        $data['adults'] = ($event->request->adults)?:'';
        $data['childs'] = ($event->request->childs)?:'';
        $data['room'] = ($event->request->room)?:'';
        $data['tourname'] = ($event->request->tourname)?:'';
        $data['price'] = ($event->request->price)?:'';
        $data['url'] = $event->request->url;

        $sendMail =  new SendMails();
        $sendMail->sendSendOrderTour($data);

    }
}
