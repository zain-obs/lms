<?php

namespace App\Livewire\RealtimeMessages;

use App\Models\Message;
use Livewire\Component;
use App\Events\MessageSent;

class RealtimeMessages extends Component
{
    public $classroomId;

    public function sendMessage($message)
    {
        if ($newMessage = Message::create(['message' => $message, 'sender' => auth()->user()->name, 'channel' => 'discussions', 'classroom_id' => $this->classroomId])) {
            broadcast(new MessageSent($newMessage->toArray()));
            $this->skipRender();
        }
    }
    public function render()
    {
        $messages = Message::where('channel', 'discussions')->where('classroom_id', $this->classroomId)->get();
        return view('livewire.realtime-messages.realtime-messages', compact('messages'));
    }
}
