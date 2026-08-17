<?php

namespace App\Listeners;

use App\Events\CertificateOrderEvent;
use App\Mail\SendMails;

class CertificateOrderHandlerListener
{
    public function __construct()
    {
        //
    }

    /**
     * Письмо менеджеру о заявке на подарочный сертификат.
     */
    public function handle(CertificateOrderEvent $event): void
    {
        $data['name'] = $event->request->name;
        $data['phone'] = $event->request->phone;
        $data['email'] = $event->request->email;
        // кому сертификат (физическим/юридическим лицам) и выбранный номинал
        $data['audience'] = ($event->request->audience) ?: '';
        $data['amount'] = ($event->request->amount) ?: '';
        $data['url'] = $event->request->url;

        $sendMail = new SendMails();
        $sendMail->sendCertificateOrder($data);
    }
}
