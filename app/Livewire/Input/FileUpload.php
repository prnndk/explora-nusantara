<?php

namespace App\Livewire\Input;

use App\Enums\FileType;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileUpload extends Component
{
    use WithFileUploads;

    public $temp_upload;
    #[Modelable]
    public $file;
    public $name, $label, $userId, $originalFileName, $hasUploaded = false, $fileModel, $required;
    public $transparent = true;

    public function mount($name, $label, $userId, $required, $transparent = true)
    {
        $this->name = $name;
        $this->label = $label;
        $this->userId = $userId;
        $this->required = $required;
        $this->transparent = $transparent;
    }

    // function to handle temp upload
    public function updatedFile($value)
    {
        $this->temp_upload = $value;

        // Pastikan hanya ambil nama file jika objeknya instance dari UploadedFile
        if ($value instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $this->originalFileName = $value->getClientOriginalName();
        } else {
            // Kalau cuma string path (file lama), pakai nama file dari path-nya saja
            $this->originalFileName = basename($value);
        }
    }

    public function saveFile()
    {
        $this->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $file_path = $this->file->store('uploads', 'public');
        $fileType = $this->file->getClientMimeType();
        if (in_array($fileType, ['image/jpeg', 'image/png', 'image/jpg'])) {
            $fileType = FileType::IMAGE;
        } elseif (in_array($fileType, ['application/pdf'])) {
            $fileType = FileType::PDF;
        } else {
            $extension = $this->file->getClientOriginalExtension();
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $fileType = FileType::IMAGE;
            } elseif (in_array($extension, ['pdf'])) {
                $fileType = FileType::PDF;
            } else {
                return $this->dispatch('toast', message: 'File type not supported', data: ['position' => 'top-right', 'type' => 'danger']);
            }
        }

        // Save file data to database
        $this->fileModel = File::create([
            'name' => 'File ' . $this->name . ' of ' . $this->userId,
            'file_path' => $file_path,
            'file_type' => $fileType,
            'uploaded_by' => $this->userId,
        ]);

        $this->file = $file_path;

        $this->hasUploaded = true;
        return $this->dispatch('toast', message: 'File uploaded successfully', data: ['position' => 'top-right', 'type' => 'success']);
    }

    public function remove()
    {
        //remove temp file
        if ($this->fileModel instanceof File) {
            $file = $this->fileModel;
            if ($file) {
                $file->delete();
            }
            // also delete the file from storage
            if ($file->file_path) {
                Storage::disk('public')->delete($file->file_path);
            }
        }
        //remove file from storage
        if ($this->temp_upload) {
            $this->temp_upload->delete();
        }
        $this->fileModel = null;
        $this->temp_upload = null;
        $this->hasUploaded = false;
        $this->file = null;
        $this->originalFileName = null;

        return $this->dispatch('toast', message: 'File removed successfully', data: ['position' => 'top-right', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.input.file-upload', ['name' => $this->name, 'label' => $this->label]);
    }
}
