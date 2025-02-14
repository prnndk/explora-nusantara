<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Otp extends Component
{
    public $otp = '';

    public function requestOtpCode()
    {
        $this->dispatch('toast', message: 'Successfully send OTP code.', data: ['position' => 'top-right', 'type' => 'success']);
        // dd('Request OTP Code');
    }

    public function submitOtp()
    {
        try {
            $this->validate([
                'otp' => 'required|numeric|digits:5'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('toast', message: $e->getMessage(), data: ['position' => 'top-right', 'type' => 'danger']);
            return;
        }

        if ($this->otp !== '12345') {
            $this->dispatch('toast', message: 'Invalid OTP code.', data: ['position' => 'top-right', 'type' => 'danger']);
            return;
        }

        $this->dispatch('toast', message: 'Verification Successful', data: ['position' => 'top-right', 'type' => 'success']);
        $this->dispatch('next');
    }

    public function render()
    {
        return view('livewire.auth.otp');
    }
}
