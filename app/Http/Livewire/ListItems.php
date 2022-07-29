<?php

namespace App\Http\Livewire;

use App\Models\ListableInterface;
use Illuminate\Support\Collection;
use Livewire\Component;

class ListItems extends Component
{
    /** @var ListableInterface[] */
    public $items = null;

    public array $columnHeaders = [];

    public function mount(ListableInterface|Collection|null $items = null, array $columnHeaders = [])
    {
        $this->items = $items;
        $this->columnHeaders = $columnHeaders;
    }

    public function render()
    {
        return view('livewire.list-items');
    }
}
