<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;

class Tag extends Component
{
    public \App\Enums\Tag $type = \App\Enums\Tag::Unknown;

    public function render()
    {
        return view('livewire.component.tag');
    }
}
