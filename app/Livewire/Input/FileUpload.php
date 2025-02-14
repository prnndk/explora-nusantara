<?php

namespace App\Livewire\Input;

use Livewire\Component;
use Livewire\WithFileUploads;

class FileUpload extends Component
{
    use WithFileUploads;
    public $file;
    private $name, $label;

    public function mount($name, $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    public function render()
    {
        return view('livewire.input.file-upload', ['name' => $this->name, 'label' => $this->label]);
    }
}
