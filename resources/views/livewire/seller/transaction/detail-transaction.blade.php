<div>
    <section class="mt-4 mx-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 mt-4 w-full">
            <div class="flex flex-col space-y-6 gap-4">
                <h6 class="font-semibold text-2xl mb-6">Product Detail</h6>
                <x-input.text label="Product Name" name="product_name" :transparent="false"
                    value="{{ $transaction->product->nama }}" readonly />
                <p class="font-semibold ">Image</p>
                <img src="/view-file/{{ $transaction->product->foto_file_id }}" alt="Card Image"
                    class="max-w-full h-64 object-cover rounded-md shadow-md">
                <h6 class="font-semibold text-2xl my-6">Buyer Detail</h6>
                <x-input.text label="Buyer Full Name" name="buyer_name" :transparent="false"
                    value="{{ $transaction->buyer->name }}" readonly />
                <x-input.text label="Company Name" name="company_name" :transparent="false"
                    value="{{ $transaction->buyer->company_name }}" readonly />
            </div>
            <div class="flex flex-col space-y-6 gap-4">
                <h6 class="font-semibold text-2xl mb-6">Transaction Detail</h6>
                <x-input.text label="Product Quantity" name="product_quantity" :transparent="false"
                    value="{{ $transaction->kuantitas_pembelian }}" readonly />
                <x-input.text label="Note To Seller" name="note_to_seller" :transparent="false"
                    value="{{ $transaction->note_to_seller }}" readonly />
                <x-input.text label="Total Price" name="total_price" :transparent="false"
                    value="Rp {{ number_format($transaction->total, 0, ',', '.') }}" readonly />
                @if ($transaction->status == App\Enums\TransactionStatus::DONE)
                    <livewire:transaction-chat :transaction="$transaction" />
                @endif

                <h6 class="font-semibold text-2xl">Contract</h6>
                <div class="flex flex-col" x-data="{ dropdownOpen: false }">
                    @if ($transaction->contract)
                        <div class="flex flex-col gap-2 ">
                            <p class="font-semibold">Status: </p>
                            <div class="w-fit">
                                <x-table.transaction-badge :status="$transaction->contract->status" />
                            </div>
                            <p class="font-semibold">File: </p>
                            <div class="relative">
                                <button @click.prevent="dropdownOpen = true"
                                    class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">
                                    <x-heroicon-o-document class="w-5 h-5 mr-3" />
                                    {{ str_replace('uploads/', '', $transaction->contract->file->file_path) }}
                                    <x-heroicon-c-ellipsis-vertical class="w-5 h-5 ml-3" />
                                </button>

                                <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                                    x-transition:enter="ease-out duration-200" x-transition:enter-start="-translate-y-2"
                                    x-transition:enter-end="translate-y-0"
                                    class="absolute right-0 top-full mt-2 z-50 w-56" x-cloak>
                                    <div
                                        class="p-1 mt-1 text-sm bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                                        <a href="/view-file/{{ $transaction->contract->file_id }}"
                                            @click="dropdownOpen = false"
                                            class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                            <span>Open File</span>
                                        </a>
                                        <button
                                            @click="dropdownOpen = false; $dispatch('open-modal', 'update-contract')"
                                            class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                            <span>Edit File</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <livewire:input.file-upload name="contract_document" label="Unggah Dokumen Kontrak"
                            user_id="{{ auth()->user()->id }}" wire:model="contract_document" :required="true"
                            :transparent="false" />
                        @error('contract_document')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <x-button type="primary" class="mt-3" wire:click="uploadContract">
                            Upload Contract
                        </x-button>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <x-modal name="update-contract" :show="false" title="Update Contract File" :withIcon="false">
        <div class="p-3 grid grid-cols-1 justify-between items-center gap-4">
            <livewire:input.file-upload name="contract_document" label="Upload Contract Document" :transparent="false"
                user_id="{{ auth()->user()->id }}" wire:model="contract_document" :required="true" />
            @error('contract_document')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            <button type="button" wire:click="updateContractDocument"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-ecstasy rounded-lg hover:bg-ecstasy-600 focus:ring-2 focus:ring-offset-2 focus:ring-ecstasy-700 focus:shadow-outline focus:outline-none">
                Update Contract File
            </button>
        </div>
    </x-modal>
</div>
