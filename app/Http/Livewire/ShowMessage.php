<?php

namespace App\Http\Livewire;

use App\Models\Message;
use Livewire\Component;

class ShowMessage extends Component
{
    /** @var Message */
    public $message;

    public function mount(Message $message)
    {
        $message->update(['read' => true]);
        $this->message = $message;
    }

    public function render()
    {
        return view('livewire.show-message');
    }

    public function deleteMessage()
    {
        $this->message->delete();

        return redirect()->route('message.list');
    }

    public function toggleRead()
    {
        $this->message->update(['read' => !$this->message->read]);
    }
}
