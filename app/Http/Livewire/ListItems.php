<?php

namespace App\Http\Livewire;

use App\Models\ListableInterface;
use Livewire\Component;

class ListItems extends Component
{
    /** @var ListableInterface[] */
    public $items;

    public array $columnHeaders = [];

    public function mount($items, array $columnHeaders = [])
    {
        $this->items = $items;
        $this->columnHeaders = $columnHeaders;
    }

    public function render()
    {
        return view('livewire.list-items');
    }
}
