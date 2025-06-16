<?php

namespace App\Livewire\Classroom;

use App\Models\Book;
use App\Models\Message;
use Livewire\Component;
use Livewire\WithFileUploads;

class ClassroomMessages extends Component
{
    use WithFileUploads;
    public $classroomId = '';
    public $message = '';
    public $booksToStore = [];
    public function addBook()
    {
        $this->validate([
            'booksToStore.*' => 'file|max:10240|required',
        ]);
        foreach ($this->booksToStore as $book) {
            $path = $book->store('booksToStore');
            Book::create(['name' => $book->getClientOriginalName(), 'path' => $path, 'classroom_id' => $this->classroomId]);
        }
        $this->reset('booksToStore');
        $this->dispatch('notification', message: 'Book uploaded!', success: true);
    }
    public function sendMessage()
    {
        if ($this->message) {
            Message::create(['message' => $this->message, 'classroom_id' => $this->classroomId, 'sender' => auth()->user()->name]);
            $this->dispatch('notification', message: 'Message Sent!', success: true);
            $this->reset('message');
        } else {
            $this->dispatch('notification', message: 'Message Empty!', success: false);
        }
    }
    public function render()
    {
        $classroom = \App\Models\Classroom::findOrFail($this->classroomId);
        $messages = $classroom->messages()->where('channel', 'announcements')->get();
        $books = $classroom->books()->get();
        return view('livewire.classroom.classroom-messages', compact(['messages','books']));
    }
}
