<div>
    <div class="w-full flex flex-col justify-center">
        <span class="my-4 text-white">{{ $label }}</span>
        <label
            class="relative border-2 border-dashed border-gray-300 bg-transparent rounded-lg p-6 flex flex-col items-center justify-center cursor-pointer hover:border-blue-500 transition-all"
            x-data="{ isDragging: false }" x-on:dragover.prevent="isDragging = true" x-on:dragleave="isDragging = false"
            x-on:drop.prevent="
                isDragging = false;
                let files = $event.dataTransfer.files;
                if (files.length > 0) {
                    $refs.fileInput.files = files;
                    $refs.fileInput.dispatchEvent(new Event('change'));
                }
            ">

            <div class="flex flex-col items-center">
                <x-heroicon-o-document-arrow-up class="h-10 w-10" />
                <p class="text-neutral-300 mt-2">Letakkan file disini!</p>
            </div>

            <!-- Hidden File Input -->
            <input type="file" class="hidden" wire:model="file" id="fileInput" x-ref="fileInput">

            <!-- Button to trigger file selection -->
            <x-button type="primary" addClasses="mt-4" x-on:click="$refs.fileInput.click()">
                <x-heroicon-o-plus class="w-5 h-5 mx-2" /> Tambahkan File
            </x-button>
        </label>

        <!-- Loading Indicator -->
        <div wire:loading wire:target="file" class="text-white">Uploading...</div>

        <p class="text-xs text-neutral-200 mt-2">Ukuran maksimal file 10 Mb dengan format .jpg, .png, .pdf</p>

        @if ($file)
            <p class="mt-2 text-green-600">File terpilih: {{ $file->getClientOriginalName() }}</p>
        @endif

        @error('file')
            <p class="text-red-500 mt-2 text-sm">{{ $message }}</p>
        @enderror
    </div>
</div>
