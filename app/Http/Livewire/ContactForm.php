<?php

namespace App\Http\Livewire;

use App\Models\Message;
use Livewire\Component;

class ContactForm extends Component
{
    public ?string $name = '';
    public ?string $email = '';
    public ?string $message = '';

    protected function getRules()
    {
        return Message::$rules;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }

    public function submitForm()
    {
        $validated = $this->validate();

        Message::create($validated);

        $this->resetForm();

        session()->flash('success', 'The message has been sent.');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->message = '';
    }
}
