<?php

namespace App\Livewire\Input;

use App\Models\File;
use App\Enums\FileType;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Modelable;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Component
{
    use WithFileUploads;

    public $temp_upload;
    #[Modelable]
    public $file;
    public $name, $label, $userId, $originalFileName, $hasUploaded = false, $fileModel, $required;

    public function mount($name, $label, $userId, $required)
    {
        $this->name = $name;
        $this->label = $label;
        $this->userId = $userId;
        $this->required = $required;
    }

    // function to handle temp upload
    public function updatedFile($value)
    {
        $this->temp_upload = $value;
        $this->originalFileName = $value->getClientOriginalName();
    }

    public function saveFile()
    {
        $this->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $file_path = $this->file->store('uploads', 'public');
        $fileType = $this->file->getClientMimeType();
        if (in_array($fileType, ['image/jpeg', 'image/png'])) {
            $fileType = FileType::IMAGE;
        } elseif (in_array($fileType, ['application/pdf'])) {
            $fileType = FileType::PDF;
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
        $this->dispatch('toast', message: 'File uploaded successfully', data: ['position' => 'top-right', 'type' => 'success']);
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

        $this->dispatch('toast', message: 'File removed successfully', data: ['position' => 'top-right', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.input.file-upload', ['name' => $this->name, 'label' => $this->label]);
    }
}