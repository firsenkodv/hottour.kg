<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;
    public $token;
    /**
     * Create a new event instance.
     * Создайте новый экземпляр события.
     */
    public function __construct($data)
    {
        $this->email = $data['email'];
        $this->token = $data['token'];
    }

    /**
     * Get the channels the event should broadcast on.
     * Найдите каналы, по которым должно транслироваться мероприятие.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
