<?php

namespace App\Http\Livewire;

use App\Models\ListableInterface;
use Livewire\Component;

class ListItems extends Component
{
    /** @var ListableInterface[] */
    public $items;

    public function mount($items)
    {
        $this->items = $items;
    }

    public function render()
    {
        return view('livewire.list-items');
    }
}
