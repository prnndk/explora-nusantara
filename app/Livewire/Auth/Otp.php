<?php

namespace App\Livewire\Auth;

use App\Enums\RegisterStatus;
use App\Models\Otp as ModelsOtp;
use App\Models\User;
use Livewire\Component;

class Otp extends Component
{
    public $otp = '';

    public User $user;

    public function mount()
    {
        $this->user = User::where('id', session('register.user_id'))->firstOrFail();
    }

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

        $register_user_id = session('register.user_id');
        $otp = ModelsOtp::where('user_id', $register_user_id)->first();

        if ($this->otp !== $otp->otp_code && $otp->isExpired()) {
            $this->dispatch('toast', message: 'Invalid OTP code.', data: ['position' => 'top-right', 'type' => 'danger']);
            return;
        }
        $this->dispatch('toast', message: 'Verification Successful', data: ['position' => 'top-right', 'type' => 'success']);

        //update user register status
        $this->user->update([
            'register_status' => RegisterStatus::CONFIRMED,
            'user_verified_at' => now(),
        ]);

        $otp->delete();

        //update session register status
        session()->put('register.current_step', 'register-data');

        $this->dispatch('next');
    }

    public function render()
    {
        return view('livewire.auth.otp');
    }
}
