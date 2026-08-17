<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Заявка на покупку подарочного сертификата (страница /sertifikaty).
 */
class CertificateOrderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
