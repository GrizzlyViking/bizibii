<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ToggleSwitch extends Component
{
    public string $bg_colour = 'bg-green-400';
    public string $animation = 'translate-x-6';
    public bool $active = false;
    public string $label = '';

    public function mount($label, $state)
    {
        $this->label = $label;
        $this->active = $state;
    }

    public function render()
    {
        return view('livewire.toggle-switch');
    }

    public function changeSwitch()
    {
        $this->active = ! $this->active;

        $this->emitUp('switchChanges', $this->active);
    }
}
