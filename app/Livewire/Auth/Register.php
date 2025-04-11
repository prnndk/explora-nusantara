<?php

namespace App\Livewire\Auth;

use App\Enums\RegisterStatus;
use App\Enums\UserRole;
use App\Events\UserCreated;
use App\Events\ValidateUserEmail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class Register extends Component
{
    public $username = '', $password = '', $email = '', $password_confirmation = '', $account_type = '';

    public function firstStep()
    {
        $this->validate([
            'username' => 'required|string|min:3|max:255|alpha_dash|unique:users,username',
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
            'password_confirmation' => 'required|same:password',
            'email' => 'required|email:rfc,dns,spoof|unique:users,email',
            'account_type' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->password = Hash::make($this->password);
            $user->role = UserRole::from($this->account_type);
            $user->register_status = RegisterStatus::WAITING;
            $user->save();

            event(new ValidateUserEmail($user));

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('toast', message: 'Error: ' . $e->getMessage(), data: ['position' => 'top-right', 'type' => 'danger']);
            return;
        }
        DB::commit();

        event(new UserCreated($user, 'register page', request()->ip(), $user->id));
        $this->dispatch('toast', message: 'Successfully Created User', data: ['position' => 'top-right', 'type' => 'success']);

        //add session to track user current step
        session()->put('register', [
            'user_id' => $user->id,
            'current_step' => 'otp',
        ]);
        $this->dispatch('next');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
