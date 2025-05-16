<div>
    <div class="w-full flex flex-col justify-center">
        <span class="my-4 {{ $transparent ? 'text-white' : 'text-neutral-700' }}">{{ $label }}</span>
        <label
            class="relative border-2 border-dashed  {{ $transparent ? 'bg-transparent border-gray-300' : 'border-gray-400' }} rounded-lg p-6 flex flex-col items-center justify-center cursor-pointer hover:border-gray-500 transition-all"
            x-data="{ isDragging: false, dropdownOpen: false }" x-on:dragover.prevent="isDragging = true" x-on:dragleave="isDragging = false"
            x-on:drop.prevent="
                isDragging = false;
                let files = $event.dataTransfer.files;
                if (files.length > 0) {
                    $refs.fileInput.files = files;
                    $refs.fileInput.dispatchEvent(new Event('change'));
                }
            ">
            @if (!$file && !$temp_upload)
                <div class="flex flex-col items-center">
                    <x-heroicon-o-document-arrow-up class="h-10 w-10" />
                    <p class="{{ $transparent ? 'text-neutral-300' : 'text-neutral-700' }} mt-2">Letakkan file disini!
                    </p>
                </div>

                <!-- Button to trigger file selection -->
                <x-button type="button" addClasses="mt-4" x-on:click.prevent="$refs.fileInput.click()"
                    wire:target.prevent="file">
                    <x-heroicon-o-plus class="w-5 h-5 mx-2" /> Tambahkan File
                </x-button>
            @else
                <div class="flex flex-col items-center mb-2">
                    <x-heroicon-o-document-text class="h-10 w-10" />
                    <p class="{{ $transparent ? 'text-neutral-100' : 'text-neutral-700' }} mt-2">
                        {{ $originalFileName }}</p>
                </div>
                <div class="relative">
                    <div class="flex flex-row gap-1">
                        @if (!$hasUploaded)
                            <x-button type="primary" addClasses="mt-4" wire:click.prevent="saveFile"
                                wire:target="saveFile">
                                <x-heroicon-o-cloud-arrow-up class="w-5 h-5 mx-2" />
                            </x-button>
                            <x-button type="warning" addClasses="mt-4" x-on:click.prevent="$refs.fileInput.click()">
                                <x-heroicon-o-pencil class="w-5 h-5 mx-2" />
                            </x-button>
                        @endif
                        <x-button type="danger" addClasses="mt-4" wire:click.prevent="remove" wire:target="remove">
                            <x-heroicon-o-trash class="w-5 h-5 mx-2" />
                        </x-button>
                    </div>
                </div>
            @endif
        </label>

        <!-- Hidden file input -->
        <input type="file" class="hidden" wire:model="file" id="fileInput" x-ref="fileInput"
            @if ($required) required @endif>

        <!-- Loading Indicator -->
        <div wire:loading wire:target="file" class="{{ $transparent ? 'text-white' : 'text-neutral-700' }}">
            Uploading...
        </div>

        <p class="text-xs {{ $transparent ? 'text-neutral-200' : 'text-neutral-700' }} mt-2">Ukuran maksimal file 10 Mb
            dengan format .jpg, .png, .pdf Untuk dapat
            menyimpan gambar klik pada ikon upload</p>

        @error('file')
            <p class="text-gray-300 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>
</div>
