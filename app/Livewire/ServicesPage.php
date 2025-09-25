<?php

namespace App\Livewire;

use Livewire\Component;

class ServicesPage extends Component
{
    public function render()
    {
        return view('livewire.services-page')
            ->layout('layouts.app', ['title' => 'Our Services - M-Blog']);
    }
}
