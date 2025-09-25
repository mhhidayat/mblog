<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ContactMessage;

class ContactPage extends Component
{
    public $name = '';
    public $email = '';
    public $subject = '';
    public $message = '';

    protected $rules = [
        'name' => 'required|min:2|max:100',
        'email' => 'required|email|max:100',
        'subject' => 'required|min:5|max:200',
        'message' => 'required|min:10|max:1000',
    ];

    public function submitContact()
    {
        $this->validate();

        // Save to database
        ContactMessage::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        session()->flash('message', 'Thank you for your message! We\'ll get back to you soon.');
        
        $this->reset(['name', 'email', 'subject', 'message']);
    }

    public function render()
    {
        return view('livewire.contact-page')
            ->layout('layouts.app', ['title' => 'Contact Us - M-Blog']);
    }
}
