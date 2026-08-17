<?php

namespace App\Listeners;

use App\Events\CalcEvent;
use App\Mail\SendMails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CalcHandlerListener
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
    public function handle(CalcEvent $event): void
    {
        $data['name'] = $event->request->name;
        $data['phone'] = $event->request->phone;
        $data['email'] = $event->request->email;
        $data['bank'] = $event->request->bank;
        $data['credit'] = $event->request->credit;
        $data['month'] = $event->request->month;
        $data['bet'] = $event->request->bet;
        $data['term'] = $event->request->term;
        $data['monthly_payment'] = $event->request->monthly_payment;
        $data['overpayment'] = $event->request->overpayment;
        $data['total_payout'] = $event->request->total_payout;
        $data['url'] = $event->request->url;

        $sendMail =  new SendMails();
        $sendMail->sendCalc($data);

    }
}
