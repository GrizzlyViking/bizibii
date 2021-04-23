<?php

namespace App\Http\Livewire;

use App\Models\Message;
use Livewire\Component;

class ListMessages extends Component
{
    public $search = '';
    public $read = false;
    public $sql = '';

    protected $listeners = [
        'switchChanges' => 'changeMarkedRead'
    ];

    public function render()
    {
        return view('livewire.list-messages', [
            'messages' => Message::where('email', 'like', '%' . $this->search . '%')
                ->when($this->read === true, function ($query) {
                    return $query->where('read', !$this->read);
                })->get()
        ]);
    }

    public function changeMarkedRead()
    {
        $this->read = ! $this->read;
    }
}
