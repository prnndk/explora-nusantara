<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Layout('components.layouts.main')]

class Login extends Component
{
    #[Validate('required|min:3')]
    public $username;
    #[Validate('required')]
    public $password;

    public function loginProcess()
    {
        $this->validate();
        sleep(5);
        $this->dispatch('toast', message: 'Successfully Login', data: ['position' => 'top-right', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
