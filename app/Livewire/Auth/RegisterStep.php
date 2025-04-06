<?php

namespace App\Livewire\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.main', ['webTitle' => 'Register Page'])]
class RegisterStep extends Component
{
    public $current = 'auth.register';

    public function mount()
    {
        if (session()->has('register')) {
            switch (session('register.current_step')) {
                case 'otp':
                    $this->current = 'auth.otp';
                    break;
                case 'register-data':
                    $this->current = 'auth.register-data';
                    break;
                default:
                    $this->current = 'auth.register';
            }
        }

        if ($this->current === 'auth.register-data') {
            //check for user role first
            $user = User::where('id', session('register.user_id'))->firstOrFail();
            if ($user->role === UserRole::BUYER) {
                $this->current = 'auth.register-data-buyer';
            } else {
                $this->current = 'auth.register-data-seller';
            }
        }
    }

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
