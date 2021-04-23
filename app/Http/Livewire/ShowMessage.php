<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowMessage extends Component
{
    public $message;

    public function mount($message)
    {
        $this->message = $message;
    }

    public function render()
    {
        return view('livewire.show-message');
    }

    public function deleteMessage()
    {
        dd('this is reached');
        $this->message->delete();

        return redirect()->route('message.list');
    }
}
