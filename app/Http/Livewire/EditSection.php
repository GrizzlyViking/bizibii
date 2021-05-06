<?php

namespace App\Http\Livewire;

use App\Models\Section;
use Livewire\Component;

class EditSection extends Component
{
    public ?Section $section;
    public $rules = [
        'section.title' => ['required', 'regex:/^[\w\d\s\-]+$/u', 'min:2', 'max:20'],
        'section.subtitle' => ['required', 'regex:/^[\w\d\s\-]+$/u', 'min:2', 'max:80'],
        'section.content' => 'required',
        'section.slug' => 'required|max:40',
        'section.published' => 'boolean',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount(Section $section)
    {
        $this->section = $section;
    }

    public function render()
    {
        return view('livewire.edit-section');
    }

    public function saveSection()
    {
        $this->section->save();

        return redirect()->route('section.list', $this->section->page);
    }
}
