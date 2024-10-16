<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class oldSMS implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $key_value;
    public $data;

    public function __construct($key_value, $data)
    {
        $this->key_value = $key_value;
        $this->data = $data;
    }

    public function broadcastOn()
    {
        return new Channel('comingSMS.' . $this->key_value);
    }

    public function broadcastWith()
    {
        return ['data' => $this->data];
    }
}
