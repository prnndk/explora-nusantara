<?php

namespace App\Livewire\Auth;

use App\Models\File;
use App\Models\User;
use App\Models\Seller;
use App\Enums\FileType;
use Livewire\Component;
use App\Enums\RegisterStatus;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Events\RegistrationCompleted;

class RegisterDataSeller extends Component
{
    use WithFileUploads;

    public $name, $email, $phone_number, $address, $nik, $photo_file_id, $ktp_file_id, $company_name, $company_address, $company_phone_number, $npwp, $nib, $bank_name, $bank_account_number, $recommendation_letter_file_id;

    private User $user;

    public $user_id;

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
            'email' => 'required|email|max:255|unique:sellers,email',
            'phone_number' => 'required|string|min:8|max:15|unique:sellers,phone_number',
            'address' => 'required|string|max:255',
            'nik' => 'required|string|min:16|max:16|unique:sellers,nik',
            'photo_file_id' => 'required',
            'ktp_file_id' => 'required',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_phone_number' => 'required|string|min:8|max:15|unique:sellers,company_phone_number',
            'npwp' => 'required|string|min:16|max:16|unique:sellers,npwp',
            'nib' => 'required|string|min:13|max:13|unique:sellers,nib',
            'bank_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:30|unique:sellers,bank_account_number',
            'recommendation_letter_file_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $this->ktp_file_id = File::where('file_path', $this->ktp_file_id)->firstOrFail();
            $this->photo_file_id = File::where('file_path', $this->photo_file_id)->firstOrFail();
            $this->recommendation_letter_file_id = File::where('file_path', $this->recommendation_letter_file_id)->firstOrFail();

            Seller::create([
                'name' => $this->name,
                'user_id' => $this->user->id,
                'nik' => $this->nik,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
                'photo_file_id' => $this->photo_file_id->id,
                'ktp_file_id' => $this->ktp_file_id->id,
                'company_name' => $this->company_name,
                'company_address' => $this->company_address,
                'company_phone_number' => $this->company_phone_number,
                'npwp' => $this->npwp,
                'nib' => $this->nib,
                'bank_name' => $this->bank_name,
                'bank_account_number' => $this->bank_account_number,
                'recommendation_letter_file_id' => $this->recommendation_letter_file_id->id,
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
            via: 'Seller Registration',
            ip_address: request()->ip(),
            user: $this->user,
        ));
        // Dispatch a success message
        $this->dispatch('toast', message: 'Successfully Created Seller Data', data: ['position' => 'top-right', 'type' => 'success']);

        return redirect()->route('login')->with('success_register', 'Successfully Created Seller Data');
    }

    public function checkMimeType($file)
    {
        $mimeType = $file->getClientMimeType();

        //if type of image then return FileType::IMAGE
        if (str_starts_with($mimeType, 'image/')) {
            return FileType::IMAGE;
        } else if (str_starts_with($mimeType, 'application/pdf')) {
            return FileType::PDF;
        }
    }

    public function render()
    {
        return view('livewire.auth.register-data-seller');
    }
}