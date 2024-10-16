<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class newSMS implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $key;
    public $data;

    public function __construct($key, $data)
    {
        $this->key = $key;
        $this->data = $data;
    }

    public function broadcastOn()
    {
      //  return new PrivateChannel('pendingSMS.' . $this->key);
      return new Channel('private-pendingSMS.' . $this->key);
    }

    public function broadcastWith()
    {
        return ['data' => $this->data];
    }
}
