<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Validation\Rules\Password;

class Register extends Component
{
    public $currentStep = 0;

    public $username = '', $password = '', $phone_number = '', $password_confirmation = '', $account_type = '';

    public function firstStep()
    {
        $this->validate([
            'username' => 'required|string|min:3|max:255',
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
            'password_confirmation' => 'required|same:password',
            'phone_number' => 'required|numeric|digits_between:8,13',
            'account_type' => 'required'
        ]);

        //send the data to parent


        $this->dispatch('next');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
