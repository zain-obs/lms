<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('classroom.' . $this->message['classroom_id']);
    }
    public function broadcastWith()
    {
        return [
            'id' => $this->message['id'],
            'message' => $this->message['message'],
            'sender' => $this->message['sender'],
            'channel' => $this->message['channel'],
            'classroom_id' => $this->message['classroom_id'],
            'created_at' => $this->message['created_at'],
        ];
    }

    public function broadcastAs()
    {
        return 'sent';
    }
}
