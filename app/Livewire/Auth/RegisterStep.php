<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.main')]
class RegisterStep extends Component
{
    public $current = 'auth.register-data';

    protected $steps = [
        'auth.register',
        'auth.otp',
        'auth.register-data'
    ];

    public function next()
    {
        $currentStepIndex = array_search($this->current, $this->steps);
        $this->current = $this->steps[$currentStepIndex + 1];
    }

    public function render()
    {
        return view('livewire.auth.register-step');
    }
}