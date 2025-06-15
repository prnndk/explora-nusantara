<div>
    <form wire:submit.prevent="handleUpdate">
        <div class="flex row gap-6 my-6">
            <x-button type="danger" class="py-3 px-8 rounded-lg" button="button"
                x-on:click="$dispatch('open-modal', 'confirm-delete')">Delete
            </x-button>
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
                        class="flex w-full h-auto min-h-[80px] px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"></textarea>
                </div>
                <x-input.text label="Price" name="price" type="number" :transparent="false" wire:model="price"
                    :required="true" />
                <x-input.text label="Stock" name="stock" :transparent="false" wire:model="stock" :required="true"
                    type="number" />
                <p class="font-semibold text-xl inline-flex items-center gap-4">Status <x-table.product-table-badge
                        :status="$product->status" /></p>

            </div>
            <div class="flex flex-col space-y-3 gap-4">
                <livewire:input.file-upload name="foto_file_id" label="Upload Gambar" user_id="{{ auth()->user()->id }}"
                    wire:model="foto_file_id" :required="!$product->file" :transparent="false" />
                <div class="space-y-6 mt-3 mb-8">
                    <h6 class="my-2">Gambar Produk</h6>
                    @if ($product->file)
                        <img src="/view-file/{{ $product->file->id }}" alt="Card Image"
                            class="max-w-full h-64 object-cover rounded-md shadow-md">
                    @else
                        <img src="{{ asset('images/mountain-placeholder.jpg') }}" alt="Placeholder Image"
                            class="max-w-full h-64 object-cover rounded-md shadow-md">
                    @endif
                </div>
            </div>
        </div>
    </form>
    <x-delete-modal name="confirm-delete" :show="false" title="Are you sure want to delete this transaction?">
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
