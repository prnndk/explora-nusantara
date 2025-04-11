<div>
    <form wire:submit.prevent="handleCreation">
        <div class="flex flex row gap-6 my-6">
            <a href="{{route('seller.product.index')}}" wire:navigate>
                <x-button type="danger" class="py-3 px-8 rounded-lg" button="button">Cancel</x-button>
            </a>
            <x-button type="success" class="py-3 px-8 rounded-lg">Save</x-button>
        </div>
        <h6 class="font-semibold text-2xl mb-6">Product Detail</h6>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 mt-4 w-full">
            <div class="flex flex-col space-y-3 gap-4">
                <x-input.text label="Product Name" name="product_name"
                              :transparent="false" wire:model="name" :required="true"/>
                <div class="flex flex-col space-y-2">
                    <label class="text-sm font-medium text-gray-900 dark:text-gray-300">Product
                        Description</label>
                    <textarea type="text" placeholder="Type your message here."
                              wire:model="description"
                              class="flex w-full h-auto min-h-[80px] px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"></textarea>
                </div>
                <x-input.text label="Price" name="price" type="number"
                              :transparent="false" wire:model="price" :required="true"/>
                <x-input.text label="Stock" name="stock"
                              :transparent="false" wire:model="stock" :required="true" type="number"/>
            </div>
            <div class="flex flex-col space-y-3 gap-4">
                <livewire:input.file-upload name="foto_file_id"
                                            label="Upload Gambar" user_id="{{ auth()->user()->id }}"
                                            wire:model="foto_file_id" :required="true" :transparent="false"/>
            </div>
        </div>
    </form>
</div>
