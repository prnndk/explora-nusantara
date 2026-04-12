<div>
    <form wire:submit.prevent="handleUpdate">
        <div class="flex row gap-6 my-6">
            <!-- <x-button type="danger" class="py-3 px-8 rounded-lg" button="button"
                x-on:click="$dispatch('open-modal', 'confirm-delete')">Delete
            </x-button> -->
            <a href="{{ route('seller.product.index') }}" wire:navigate>
                <x-button type="danger" class="py-3 px-8 rounded-lg" button="button">
                    Cancel
                </x-button>
            </a>
            <x-button type="success" class="py-3 px-8 rounded-lg">Save</x-button>
        </div>
        <h6 class="font-semibold text-2xl mb-6">Product Detail</h6>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 mt-4 w-full">
            <div class="flex flex-col space-y-3 gap-4">
                <x-input.text label="Product Name" name="product_name" :transparent="false" wire:model="name"
                    :required="true" />
                <div class="flex flex-col space-y-2">
                    <label class="text-sm font-medium text-gray-900 dark:text-gray-300">Product
                        Description</label>
                    <textarea type="text" placeholder="Type your message here." wire:model="description"
                        class="flex w-full h-auto min-h-[250px] px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"></textarea>
                </div>
                <x-input.text label="Price" name="price" type="number" :transparent="false" wire:model="price"
                    :required="true" />
                <x-input.text label="Stock" name="stock" :transparent="false" wire:model="stock" :required="true"
                    type="number" />
                <p class="font-semibold text-xl inline-flex items-center gap-4">Status <x-table.product-table-badge
                        :status="$product->status" /></p>

            </div>
            <div class="flex flex-col space-y-3 gap-2">
                <div x-data="{ open: false }">

                    <button type="button" @click="open = !open" class="text-sm text-blue-600">
                        Edit Gambar Utama
                    </button>

                    <div x-show="open" class="mt-3">
                        <livewire:input.file-upload name="foto_file_id" label="Upload Gambar" user_id="{{ auth()->user()->id }}"
                            wire:model="foto_file_id" :required="!$product->file" :transparent="false" />
                        
                        <!-- @if ($foto_file_id)
                        <div class="mt-2">
                            <p class="text-xs text-green-600">Preview Cover Baru</p>

                            <img src="{{ asset($foto_file_id) }}"
                                class="w-full h-40 object-cover rounded-lg border">
                        </div>
                        @endif -->
                    </div>
                </div>
                <div class="space-y-3 mt-3 mb-8">
                    <h6 class="my-2">Gambar Utama</h6>
                    @if ($product->file)
                    <img src="/view-file/{{ $product->file->id }}" alt="Card Image"
                        class="max-w-full h-64 object-cover rounded-md shadow-md">
                    @else
                    <img src="{{ asset('images/mountain-placeholder.jpg') }}" alt="Placeholder Image"
                        class="max-w-full h-64 object-cover rounded-md shadow-md">
                    @endif
                    <div class="grid grid-cols-3 gap-3">
                        @foreach ($product->images as $img)
                        <div class="relative group">

                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                class="w-full h-24 object-cover rounded-lg border">

                            <!-- Delete button -->
                            <button type="button"
                                onclick="confirm('Hapus gambar ini?') || event.stopImmediatePropagation()"
                                wire:click="deleteImage('{{ $img->id }}')"
                                class="absolute top-1 right-1 bg-red-500 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                                ✕
                            </button>
                        </div>
                        @endforeach
                    </div>

                    <!-- Upload New Images -->
                    <div class="mt-4">
                        <label class="text-sm font-medium">Tambah Gambar (Max 5)</label>

                        @if (($product->images->count() + count($images)) < 5)
                            <label class="border-2 border-dashed rounded-lg p-4 text-center cursor-pointer hover:bg-gray-50 mt-2 block">
                            <span class="text-sm text-gray-500">Klik untuk tambah gambar</span>
                            <input type="file" wire:model="images" multiple class="hidden">
                            </label>
                            @else
                            <p class="text-sm text-gray-400">
                                Maksimal 5 gambar. Hapus file yang ada untuk mengunggah gambar baru.
                            </p>
                            @endif

                            <div wire:loading wire:target="images" class="text-sm text-gray-500">
                                Uploading...
                            </div>

                            <!-- Preview new images -->
                            @if ($images)
                            <div class="grid grid-cols-3 gap-3 mt-2">
                                @foreach ($images as $image)
                                <img src="{{ $image->temporaryUrl() }}"
                                    class="w-full h-24 object-cover rounded-lg border">
                                @endforeach
                            </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
    <x-delete-modal name="confirm-delete" :show="false" title="Are you sure you want to delete this product?">
        <div class="p-3 grid grid-cols-2 justify-between items-center gap-4">
            <button type="button" x-on:click="$dispatch('close-modal', 'confirm-delete')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-red-normal hover:text-white transition-colors duration-200 bg-transparent border border-red-normal rounded-lg hover:bg-red-normal focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:shadow-outline focus:outline-none">
                No
            </button>
            <button type="button" wire:click="deleteProduct" x-on:click="$dispatch('close-modal', 'confirm-delete')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-red-normal rounded-lg hover:bg-red-dark focus:ring-2 focus:ring-offset-2 focus:ring-red-dark focus:shadow-outline focus:outline-none">
                Yes
            </button>
        </div>
    </x-delete-modal>

</div>