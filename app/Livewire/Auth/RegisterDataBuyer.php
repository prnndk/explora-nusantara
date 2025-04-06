<?php

namespace App\Livewire\Auth;

use App\Models\File;
use App\Models\User;
use Livewire\Component;
use App\Enums\RegisterStatus;
use Illuminate\Support\Facades\DB;
use App\Events\RegistrationCompleted;
use App\Models\Buyer;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class RegisterDataBuyer extends Component
{
    use WithFileUploads;

    private User $user;

    public $user_id, $name, $email, $phone_number, $address, $nik, $photo_file_id, $ktp_file_id, $company_name, $company_address, $company_phone_number, $country, $bank_name, $bank_account_number, $legality_file_id;

    public function __construct()
    {
        $this->user = User::where('id', session('register.user_id'))->firstOrFail();
    }

    public function mount()
    {
        $this->user_id = $this->user->id;
    }

    public function submitData()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:buyers,email',
            'phone_number' => 'required|string|min:8|max:15|unique:buyers,phone_number',
            'address' => 'required|string|max:255',
            'nik' => 'required|string|min:16|max:16|unique:buyers,nik',
            'photo_file_id' => 'required',
            'ktp_file_id' => 'required',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_phone_number' => 'required|string|min:8|max:15|unique:buyers,company_phone_number',
            'bank_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:30|unique:buyers,bank_account_number',
            'legality_file_id' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $this->ktp_file_id = File::where('file_path', $this->ktp_file_id)->firstOrFail();
            $this->photo_file_id = File::where('file_path', $this->photo_file_id)->firstOrFail();
            $this->legality_file_id = File::where('file_path', $this->legality_file_id)->firstOrFail();

            Buyer::create([
                'name' => $this->name,
                'nik' => $this->nik,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
                'photo_file_id' => $this->photo_file_id->id,
                'ktp_file_id' => $this->ktp_file_id->id,
                'company_name' => $this->company_name,
                'company_address' => $this->company_address,
                'company_phone_number' => $this->company_phone_number,
                'bank_name' => $this->bank_name,
                'bank_account_number' => $this->bank_account_number,
                'legality_file_id' => $this->legality_file_id->id,
            ]);

            $this->user->update([
                'register_status' => RegisterStatus::VERIFIED,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('toast', message: 'Error: ' . $e->getMessage(), data: ['position' => 'top-right', 'type' => 'danger']);
            return;
        }
        DB::commit();
        session()->forget('register');
        event(new RegistrationCompleted(
            user_id: $this->user->id,
            via: 'Buyer Self Registration',
            ip_address: request()->ip(),
            user: $this->user,
        ));

        $this->dispatch('toast', message: 'Successfully Created Buyer Data', data: ['position' => 'top-right', 'type' => 'success']);

        return redirect()->route('login')->with('success_register', 'Successfully Created Buyer Data');
    }
    public function render()
    {
        return view('livewire.auth.register-data-buyer');
    }
}
