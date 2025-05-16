<?php

namespace App\Livewire;

use App\Models\File;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('components.layouts.dashboard', ['webTitle' => 'User Profile'])]
class UserProfile extends Component
{
    public $user;

    public $name, $nik, $phone_number, $address, $email, $bank_name, $bank_account_number, $npwp, $nib, $country, $company_name, $company_address, $company_phone_number;

    public $profile_picture, $user_ktp, $legality_file_buyer, $recommendation_letter_seller;

    public function mount()
    {

        $this->user = User::where('id', auth()->user()->id)->with(['seller', 'buyer'])->firstOrFail();
        if ($this->user->isAdmin()) {
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

    public function updateRecommendationLetter()
    {
        //validate
        $this->validate([
            'recommendation_letter_seller' => 'required|string|exists:files,file_path',
        ]);

        $fileId = File::where('file_path', $this->recommendation_letter_seller)->firstOrFail()->id;

        if ($this->user->isSeller()) {
            $deleteFile = File::where('id', $this->user->seller->recommendation_letter_file_id)->first();
            if ($deleteFile) {
                $filePath = $deleteFile->file_path;
                if (file_exists(storage_path('app/public/' . $filePath))) {
                    unlink(storage_path('app/public/' . $filePath));
                }
                $deleteFile->delete();
            }
            $this->user->seller->update([
                'recommendation_letter_file_id' => $fileId,
            ]);
        } else {
            return $this->dispatch('toast', message: 'Fitur ini belum tersedia', data: ['position' => 'top-right', 'type' => 'info']);
        }

        $this->dispatch('close-modal', 'update-recommendation-letter');

        return $this->dispatch('toast', message: 'Berhasil update surat rekomendasi', data: ['position' => 'top-right', 'type' => 'info']);
    }

    public function updateLegalityFile()
    {
        //validate
        $this->validate([
            'legality_file_buyer' => 'required|string|exists:files,file_path',
        ]);

        $fileId = File::where('file_path', $this->legality_file_buyer)->firstOrFail()->id;

        if ($this->user->isBuyer()) {
            $deleteFile = File::where('id', $this->user->buyer->legality_letter_file_id)->first();
            if ($deleteFile) {
                //delete file from storage
                $filePath = $deleteFile->file_path;
                if (file_exists(storage_path('app/public/' . $filePath))) {
                    unlink(storage_path('app/public/' . $filePath));
                }
                $deleteFile->delete();
            }
            $this->user->buyer->update([
                'legality_letter_file_id' => $fileId,
            ]);
        } else {
            return $this->dispatch('toast', message: 'Fitur ini belum tersedia', data: ['position' => 'top-right', 'type' => 'info']);
        }

        $this->dispatch('close-modal', 'update-legality-file');

        return $this->dispatch('toast', message: 'Berhasil update surat legalitas', data: ['position' => 'top-right', 'type' => 'info']);
    }

    public function updateKTP()
    {
        //validate
        $this->validate([
            'user_ktp' => 'required|string|exists:files,file_path',
        ]);

        $fileId = File::where('file_path', $this->user_ktp)->firstOrFail()->id;

        if ($this->user->isBuyer()) {
            $deleteFile = File::where('id', $this->user->buyer->ktp_file_id)->first();
            if ($deleteFile) {
                //delete file from storage
                $filePath = $deleteFile->file_path;
                if (file_exists(storage_path('app/public/' . $filePath))) {
                    unlink(storage_path('app/public/' . $filePath));
                }
                $deleteFile->delete();
            }
            $this->user->buyer->update([
                'ktp_file_id' => $fileId,
            ]);
        } else {
            $deleteFile = File::where('id', $this->user->seller->ktp_file_id)->first();
            if ($deleteFile) {
                $filePath = $deleteFile->file_path;
                if (file_exists(storage_path('app/public/' . $filePath))) {
                    unlink(storage_path('app/public/' . $filePath));
                }
                $deleteFile->delete();
            }
            $this->user->seller->update([
                'ktp_file_id' => $fileId,
            ]);
        }
        $this->dispatch('close-modal', 'update-ktp');

        return $this->dispatch('toast', message: 'Berhasil update foto KTP', data: ['position' => 'top-right', 'type' => 'info']);
    }

    public function updateProfilePicture()
    {
        //validate
        $this->validate([
            'profile_picture' => 'required|string|exists:files,file_path',
        ]);

        $fileId = File::where('file_path', $this->profile_picture)->firstOrFail()->id;

        if ($this->user->isBuyer()) {
            $deleteFile = File::where('id', $this->user->buyer->photo_file_id)->first();
            if ($deleteFile) {
                //delete file from storage
                $filePath = $deleteFile->file_path;
                if (file_exists(storage_path('app/public/' . $filePath))) {
                    unlink(storage_path('app/public/' . $filePath));
                }
                $deleteFile->delete();
            }
            $this->user->buyer->update([
                'photo_file_id' => $fileId,
            ]);
        } else {
            $deleteFile = File::where('id', $this->user->seller->photo_file_id)->first();
            if ($deleteFile) {
                $filePath = $deleteFile->file_path;
                if (file_exists(storage_path('app/public/' . $filePath))) {
                    unlink(storage_path('app/public/' . $filePath));
                }
                $deleteFile->delete();
            }
            $this->user->seller->update([
                'photo_file_id' => $fileId,
            ]);
        }

        return $this->dispatch('toast', message: 'Fitur ini belum tersedia', data: ['position' => 'top-right', 'type' => 'info']);
    }

    public function save()
    {
        if ($this->user->isBuyer()) {

            $this->validate([
                'name' => 'required|string|max:255',
                'nik' => [
                    'required',
                    'string',
                    'min:16',
                    'max:16',
                    Rule::unique('buyers', 'nik')->ignore($this->user->buyer->id),
                ],
                'phone_number' => [
                    'required',
                    'string',
                    'min:8',
                    'max:15',
                    Rule::unique('buyers', 'phone_number')->ignore($this->user->buyer->id),
                ],
                'address' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('buyers', 'email')->ignore($this->user->buyer->id),
                ],
                'bank_name' => 'required|string|max:255',
                'bank_account_number' => [
                    'required',
                    'string',
                    'max:30',
                    Rule::unique('buyers', 'bank_account_number')->ignore($this->user->buyer->id),
                ],
                'country' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'company_address' => 'required|string|max:255',
                'company_phone_number' => [
                    'required',
                    'string',
                    'min:8',
                    'max:15',
                    Rule::unique('buyers', 'company_phone_number')->ignore($this->user->buyer->id),
                ],
            ]);

            $this->user->buyer->update([
                'name' => $this->name,
                'nik' => $this->nik,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
                'bank_name' => $this->bank_name,
                'bank_account_number' => $this->bank_account_number,
                'country' => $this->country,
                'company_name' => $this->company_name,
                'company_address' => $this->company_address,
                'company_phone_number' => $this->company_phone_number
            ]);
        } else {
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:sellers,email,' . $this->user->seller->id,
                'phone_number' => 'required|string|min:8|max:15|unique:sellers,phone_number,' . $this->user->seller->id,
                'address' => 'required|string|max:255',
                'nik' => 'required|string|min:16|max:16|unique:sellers,nik,' . $this->user->seller->id,
                'company_name' => 'required|string|max:255',
                'company_address' => 'required|string|max:255',
                'company_phone_number' => 'required|string|min:8|max:15|unique:sellers,company_phone_number,' . $this->user->seller->id,
                'npwp' => 'required|string|min:16|max:16|unique:sellers,npwp,' . $this->user->seller->id,
                'nib' => 'required|string|min:13|max:13|unique:sellers,nib,' . $this->user->seller->id,
                'bank_name' => 'required|string|max:255',
                'bank_account_number' => 'required|string|max:30|unique:sellers,bank_account_number,' . $this->user->seller->id,
            ]);

            $this->user->seller->update([
                'name' => $this->name,
                'nik' => $this->nik,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
                'email' => $this->email,
                'bank_name' => $this->bank_name,
                'bank_account_number' => $this->bank_account_number,
                'npwp' => $this->npwp,
                'nib' => $this->nib,
                'company_name' => $this->company_name,
                'company_address' => $this->company_address,
                'company_phone_number' => $this->company_phone_number
            ]);
        }
        $this->dispatch('toast', message: 'Berhasil Mengubah Data', data: ['position' => 'top-right', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
