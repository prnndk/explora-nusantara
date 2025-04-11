<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('components.layouts.dashboard', ['webTitle' => 'User Profile'])]
class UserProfile extends Component
{
    public $user;

    public $name, $nik, $phone_number, $address, $email, $bank_name, $bank_account_number, $npwp, $nib, $country, $company_name, $company_address, $company_phone_number;

    public function mount()
    {

        $this->user = User::where('id', auth()->user()->id)->with(['seller', 'buyer'])->firstOrFail();
        if ($this->user->isAdmin()){
            return;
        }
        $this->name = $this->user->seller->name ?? $this->user->buyer->name;
        $this->nik = $this->user->seller->nik ?? $this->user->buyer->nik;
        $this->phone_number = $this->user->seller->phone_number ?? $this->user->buyer->phone_number;
        $this->address = $this->user->seller->address ?? $this->user->buyer->address;
        $this->email = $this->user->email;
        $this->bank_name = $this->user->seller->bank_name ?? $this->user->buyer->bank_name;
        $this->bank_account_number = $this->user->seller->bank_account_number ?? $this->user->buyer->bank_account_number;
        if ($this->user->isBuyer()) {
            $this->country = $this->user->buyer->country;
        } else {
            $this->npwp = $this->user->seller->npwp;
            $this->nib = $this->user->seller->nib;
        }
        $this->company_name = $this->user->buyer->company_name ?? $this->user->seller->company_name;
        $this->company_address = $this->user->buyer->company_address ?? $this->user->seller->company_address;
        $this->company_phone_number = $this->user->buyer->company_phone_number ?? $this->user->seller->company_phone_number;
    }

    public function changePassword()
    {
        return $this->redirect('user-profile/change-password', navigate: true);
    }

    public function save(){
        $this->dispatch('toast', message: 'Feature not yet implemented', data: ['position' => 'top-center', 'type' => 'info']);
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
