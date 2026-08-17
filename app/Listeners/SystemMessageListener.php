<?php

namespace App\Listeners;

use App\Events\SystemMessageEvent;
use App\Mail\SendMails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Throwable;

class SystemMessageListener
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
    public function handle(SystemMessageEvent $event): void
    {

        $data['file_commands'] = $event->request['file_commands'];
        $data['commands'] = $event->request['commands'];
        $data['body'] = $event->request['body'];

        try {
            $sendMail = new SendMails();
            $sendMail->sendSystemMessage($data);
        } catch (Throwable $e) {
            Log::warning("Не удалось отправить системное письмо ({$data['commands']}): " . $e->getMessage());
        }

    }
}
