<div>
    <div class="flex gap-2">
        <a href="{{ route('admin.contract.index') }}" wire:navigate class="mt-1">
            <x-heroicon-o-arrow-left-circle class="size-8" />
        </a>
        <div class="">
            <h1 class="text-4xl font-bold">Contract#{{ $contract->id }}</h1>
            <div class="flex flex-row gap-4 mb-6 mt-4">
                <p class="text-md">Created At
                    {{ \Carbon\Carbon::make($contract->created_at)->monthName . ', ' . \Carbon\Carbon::make($contract->created_at) }}
                </p>
                <x-table.product-table-badge :status="$contract->status" />
            </div>
        </div>
    </div>
    <div class="" x-data="{ tab: 'buyer' }">

        <div class="grid grid-cols-1 md:grid-cols-2">

            <div class="grid grid-cols-4 mb-5">
                <button x-on:click="tab = 'buyer'" :class="{ 'font-semibold': tab === 'buyer' }">Buyer</button>
                <button x-on:click="tab = 'seller'" :class="{ 'font-semibold': tab === 'seller' }">Seller</button>
                <button x-on:click="tab = 'product'" :class="{ 'font-semibold': tab === 'product' }">Product</button>
                <button x-on:click="tab = 'file'" :class="{ 'font-semibold': tab === 'file' }">File</button>
            </div>

            <div class="flex flex-row items-start justify-end space-x-3 gap-3">
                <x-button type="danger" class="py-3 px-8 rounded-lg" button="button"
                    x-on:click="$dispatch('open-modal', 'confirm-delete')">Reject
                </x-button>
                <x-button type="success" class="py-3 px-8 rounded-lg"
                    x-on:click="$dispatch('open-modal','confirm-action')">Approve</x-button>
            </div>
        </div>
        <div class="flex flex-col gap-5">
            <div x-show="tab === 'buyer'">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="flex flex-col gap-2 space-y-2">
                        <x-input.text label="Your Name" name="name" value="{{ $contract->buyer->name }}"
                            :required="true" readonly />
                        <x-input.text label="NIK" name="nik" value="{{ $contract->buyer->nik }}"
                            :required="true" readonly />
                        <x-input.text label="NIK" name="nik" value="{{ $contract->buyer->email }}"
                            :required="true" readonly />
                        <x-input.tel label="Phone Number" name="phone_number"
                            value="{{ $contract->buyer->phone_number }}" :required="true" readonly />
                        <x-input.text label="Address" name="address" value="{{ $contract->buyer->address }}"
                            :required="true" readonly />
                        <x-input.text label="Company Name" name="company_name"
                            value="{{ $contract->buyer->company_name }}" :required="true" readonly />
                    </div>
                </div>
            </div>
            <div x-show="tab === 'seller'">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="flex flex-col gap-2 space-y-2">
                        <x-input.text label="Your Name" name="name" value="{{ $contract->seller->name }}"
                            :required="true" readonly />
                        <x-input.text label="NIK" name="nik" value="{{ $contract->seller->nik }}"
                            :required="true" readonly />
                        <x-input.text label="Email" name="email" value="{{ $contract->seller->email }}"
                            :required="true" readonly />
                        <x-input.tel label="Phone Number" name="phone_number"
                            value="{{ $contract->seller->phone_number }}" :required="true" readonly />
                        <x-input.text label="Address" name="address" value="{{ $contract->seller->address }}"
                            :required="true" readonly />
                        <x-input.text label="Company Name" name="company_name"
                            value="{{ $contract->seller->company_name }}" :required="true" readonly />
                    </div>
                </div>
            </div>
            <div x-show="tab === 'product'">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="flex flex-col gap-2 space-y-2">
                        <x-input.text label="Product ID" name="product_id" :transparent="false"
                            value="{{ $contract->product->id }}" :required="true" readonly />
                        <x-input.text label="Product Name" name="product_name" :transparent="false"
                            value="{{ $contract->product->nama }}" :required="true" readonly />
                        <div class="flex flex-col space-y-2">
                            <label class="text-sm font-medium text-gray-900 dark:text-gray-300">Product
                                Description</label>
                            <textarea type="text" placeholder="Type your message here." readonly
                                class="flex w-full h-auto min-h-[80px] px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50">{{ $contract->product->deskripsi }}</textarea>
                        </div>
                        <x-input.text label="Product Supplier" name="supplier" :transparent="false"
                            value="{{ $contract->product->seller->company_name }}" :required="true" readonly />
                        <x-input.text label="Price" name="price" type="text" :transparent="false"
                            value="Rp {{ number_format($contract->product->harga, 0, ',', '.') }}" :required="true"
                            readonly />
                        <p class="font-semibold text-xl inline-flex items-center gap-4">Status
                            <x-table.product-table-badge :status="$contract->product->status" />
                        </p>
                    </div>
                    <div class="flex flex-col gap-2 space-y-2">
                        <div class="space-y-6 mt-3 mb-8">
                            <h6 class="my-2">Gambar Produk</h6>
                            <img src="/view-file/{{ $contract->product->foto_file_id }}" alt="Card Image"
                                class="max-w-full h-64 object-cover rounded-md shadow-md">
                        </div>
                    </div>
                </div>
            </div>
            <div x-show="tab==='file'">
                <span class="block mb-2 text-sm tracking-wide text-gray-500">Document Contract</span>
                <div x-data="{ dropdownOpen: false }" class="relative">

                    <button @click.prevent="dropdownOpen = true"
                        class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">
                        <x-heroicon-o-document class="w-5 h-5 mr-3" />
                        @if ($contract->file_id)
                            {{ str_replace('uploads/', '', $contract->file->file_path) }}
                        @endif
                        No Document Available
                        <x-heroicon-c-ellipsis-vertical class="w-5 h-5 ml-3" />
                    </button>

                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                        x-transition:enter="ease-out duration-200" x-transition:enter-start="-translate-y-2"
                        x-transition:enter-end="translate-y-0" class="absolute top-full left-0 mt-2 z-50 w-56"
                        x-cloak>
                        @if ($contract->file_id)
                            <div
                                class="p-1 mt-1 text-sm bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                                <a href="/view-file/{{ $contract->file_id }}" @click="dropdownOpen = false"
                                    class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                    <span>Open File</span>
                                </a>
                                <a href="#_" @click="dropdownOpen = false"
                                    class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                    <span>Edit File</span>
                                </a>
                                <a href="#_" @click="dropdownOpen = false"
                                    class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                    <span>Delete File</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    <x-delete-modal name="confirm-delete" :show="false" title="Are you sure want to reject this contract?">
        <div class="p-3 grid grid-cols-2 justify-between items-center gap-4">
            <button type="button" x-on:click="$dispatch('close-modal', 'confirm-delete')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-red-normal hover:text-white transition-colors duration-200 bg-transparent border border-red-normal rounded-lg hover:bg-red-normal focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:shadow-outline focus:outline-none">
                No
            </button>
            <button type="button" wire:click="rejectContract"
                x-on:click="$dispatch('close-modal', 'confirm-delete')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-red-normal rounded-lg hover:bg-red-dark focus:ring-2 focus:ring-offset-2 focus:ring-red-dark focus:shadow-outline focus:outline-none">
                Yes
            </button>
        </div>
    </x-delete-modal>
    <x-warning-modal name="confirm-action" :show="false" title="Are you sure want to approve this product?">
        <div class="p-3 grid grid-cols-2 justify-between items-center gap-4">
            <button type="button" x-on:click="$dispatch('close-modal', 'confirm-action')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-gray-700 hover:text-black transition-colors duration-200 bg-transparent border border-gray-700 rounded-lg hover:bg-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-700 focus:shadow-outline focus:outline-none">
                No
            </button>
            <button type="button" wire:click="approveContract"
                x-on:click="$dispatch('close-modal', 'confirm-action')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-mainGreen rounded-lg hover:bg-teal-700 focus:ring-2 focus:ring-offset-2 focus:ring-teal-700 focus:shadow-outline focus:outline-none">
                Yes
            </button>
        </div>
    </x-warning-modal>

</div>
