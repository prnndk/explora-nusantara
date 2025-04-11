<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.dashboard', ['webTitle' => 'Change Password'])]
class ChangePassword extends Component
{
    #[Validate]
    public $current_password;
    #[Validate]
    public $new_password;
    #[Validate]
    public $new_password_confirmation;

    public function back()
    {
        return $this->redirect('/user-profile', navigate: true);
    }

    public function savePassword()
    {
        try {
            $this->validate([
                'current_password' => 'required',
                'new_password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
                'new_password_confirmation' => 'required|same:new_password',
            ]);

            $user = User::where('id', auth()->user()->id)->firstOrFail();

            if (Hash::check($this->new_password, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'Current password is incorrect.',
                ]);
            }


            $user->update([
                'password' => Hash::make($this->new_password),
            ]);

            $this->dispatch('toast', message: 'Successfully Updated Password', data: ['position' => 'top-right', 'type' => 'success']);
            $this->dispatch('close-modal', 'update-password');

            return $this->redirect('/user-profile', navigate: true);

        } catch (ValidationException $exception) {
            $this->setErrorBag($exception->validator->errors());
            $this->dispatch('toast', message: 'Error: ' . $exception->getMessage(), data: ['position' => 'top-right', 'type' => 'danger']);
            $this->dispatch('close-modal', 'update-password');
            return;
        } catch (\Exception $exception) {
            $this->dispatch('toast', message: 'Error: ' . $exception->getMessage(), data: ['position' => 'top-right', 'type' => 'danger']);
            $this->dispatch('close-modal', 'update-password');
            return;
        }
    }

    public function render()
    {
        return view('livewire.change-password');
    }

    protected function rules()
    {
        return [
            'current_password' => 'required',
            'new_password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
            'new_password_confirmation' => 'required|same:new_password',
        ];
    }
}
