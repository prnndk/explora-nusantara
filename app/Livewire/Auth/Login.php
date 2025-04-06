<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Layout('components.layouts.main', ['webTitle' => 'Login Page'])]

class Login extends Component
{
    #[Validate('required|string|min:3')]
    public $username;
    #[Validate('required')]
    public $password;

    public function loginProcess()
    {
        $this->validate();

        $process = Auth::attempt(['username' => $this->username, 'password' => $this->password]);


        if (!$process) {
            $this->dispatch('toast', message: 'Invalid Credentials', data: ['position' => 'top-right', 'type' => 'danger']);
            return;
        }

        session()->regenerate();

        $this->dispatch('toast', message: 'Successfully Login', data: ['position' => 'top-right', 'type' => 'success']);
        $this->redirectRoute('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
