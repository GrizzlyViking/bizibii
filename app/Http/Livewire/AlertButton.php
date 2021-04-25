<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AlertButton extends Component
{
    public $attributes;

    public function render()
    {
        return view('livewire.alert-button');
    }
}
