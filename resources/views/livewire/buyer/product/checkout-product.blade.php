<div>
    <div class="flex gap-2 mb-6">
        <button wire:click="back" wire:navigate class="mt-1">
            <x-heroicon-o-arrow-left-circle class="size-8" />
        </button>
        <div class="flex flex-col gap-2">
            <h1 class="text-4xl font-bold">Checkout Product</h1>
            <p>
                Complete your order easily and securely. Double check your order details before proceeding with payment.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mx-8">
        <div class="flex flex-col gap-4">
            <div class="bg-gray-100 rounded-xl p-4 flex justify-between items-start">
                <div>
                    <div class="flex flex-col items-start gap-2 mt-2">
                        <h3 class="text-gray-500 font-semibold uppercase text-sm">Alamat Pengiriman</h3>
                        @if ($shipping_address_name || $shipping_address)
                        <div class="flex flex-col gap-3">
                            <div class="flex flex-row gap-3 items-center">
                                <x-heroicon-s-map-pin class="size-6 text-mainGreen" />
                                <p class="font-semibold">{{ $shipping_address_name ?? 'No name specified' }}</p>
                            </div>
                            <p class="text-gray-700">{{ $shipping_address ?? 'No address specified' }}</p>
                        </div>
                        @else
                        @error('shipping_address')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="flex flex-col gap-3">
                            <p class="text-gray-500 italic">Please add a shipping address</p>
                        </div>
                        @endif
                    </div>
                </div>
                <button x-on:click="$dispatch('open-modal', 'change-address')"
                    class="border border-gray-300 text-gray-500 rounded-md px-3 py-1 text-sm hover:bg-gray-200">
                    Change
                </button>

            </div>
            <div class="bg-gray-100 rounded-xl p-4 flex gap-4">
                @if ($product->file)
                <img src="/view-file/{{ $product->file->id }}" alt="Product Image"
                    class="w-24 h-24 rounded-lg object-cover" />
                @else
                <img src="{{ asset('images/mountain-placeholder.jpg') }}" alt="Product Image"
                    class="w-24 h-24 rounded-lg object-cover" />
                @endif
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-lg">{{ $product->nama }}</h3>
                            <p class="text-gray-500 text-sm">NORMAL</p>
                            <div class="flex items-center gap-2 mt-4">
                                <x-heroicon-s-building-office class="w-5 h-5 text-mainGreen" />
                                <p class="text-gray-700">{{ $product->seller->company_name }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col items-center gap-2"
                            x-data="{ quantity: @entangle('quantity'), minOrder: 12, harga: {{ $product->harga }} }">
                            <div class="flex justify-center">
                                <div class="flex items-center gap-1 bg-white border border-gray-300 rounded-lg p-1">
                                    <button type="button"
                                        @click="if(quantity > minOrder) { quantity--; $wire.set('quantity', quantity); }"
                                        class="p-1 text-gray-500 hover:text-red-600 transition disabled:opacity-50"
                                        :disabled="quantity <= minOrder">
                                        <x-heroicon-o-minus class="w-5 h-5" />
                                    </button>

                                    <input type="number"
                                        x-model.number="quantity"
                                        @blur="if(quantity < minOrder) quantity = minOrder; $wire.set('quantity', quantity)"
                                        class="w-12 text-center border-none focus:ring-0 p-0 text-sm font-semibold" />

                                    <button type="button"
                                        @click="quantity++; $wire.set('quantity', quantity);"
                                        class="p-1 text-gray-500 hover:text-green-600 transition">
                                        <x-heroicon-o-plus class="w-5 h-5" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 border border-gray-300 rounded-lg p-3">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-gray-700 font-semibold">Shipping Options</h3>
                        </div>

                        <div x-data="{ open: false, selected: 'economic' }" class="relative">
                            <button @click="open = !open" type="button"
                                class="flex justify-between w-full px-4 py-3 bg-white border border-gray-300 rounded-lg">
                                <div class="flex flex-col items-start">
                                    <span class="font-semibold"
                                        x-text="selected === 'economic' ? 'Economic' : (selected === 'reguler' ? 'Reguler' : 'Premium')"></span>
                                    <span class="text-gray-500 text-sm" x-show="selected === 'economic'">
                                        Estimated arrival on {{ \Carbon\Carbon::now()->monthName }}
                                        {{ \Carbon\Carbon::now()->addDay(10)->day . ' - ' . \Carbon\Carbon::now()->addDay(15)->day }}
                                    </span>
                                    <span class="text-gray-500 text-sm" x-show="selected === 'reguler'">
                                        Estimated arrival on {{ \Carbon\Carbon::now()->monthName }}
                                        {{ \Carbon\Carbon::now()->addDay(7)->day . ' - ' . \Carbon\Carbon::now()->addDay(9)->day }}
                                    </span>
                                    <span class="text-gray-500 text-sm" x-show="selected === 'premium'">
                                        Estimated arrival on {{ \Carbon\Carbon::now()->monthName }}
                                        {{ \Carbon\Carbon::now()->addDay(4)->day . ' - ' . \Carbon\Carbon::now()->addDay(6)->day }}
                                    </span>
                                </div>
                                <x-heroicon-s-chevron-down class="w-5 h-5 text-gray-500" ::class="{ 'rotate-180': open }" />
                            </button>

                            <div x-show="open" @click.away="open = false"
                                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                <div class="p-3 cursor-pointer hover:bg-gray-100"
                                    @click="selected = 'economic'; open = false; @this.shippingMethod = 'economic'; @this.shippingCost = 20000">
                                    <p class="font-semibold">Economic (Rp20.000)</p>
                                    <p class="text-gray-500 text-sm">Estimated arrival on
                                        {{ \Carbon\Carbon::now()->monthName }}
                                        {{ \Carbon\Carbon::now()->addDay(10)->day . ' - ' . \Carbon\Carbon::now()->addDay(15)->day }}
                                    </p>
                                </div>
                                <div class="p-3 cursor-pointer hover:bg-gray-100"
                                    @click="selected = 'reguler'; open = false; @this.shippingMethod = 'reguler'; @this.shippingCost = 50000">
                                    <p class="font-semibold">Reguler (Rp50.000)</p>
                                    <p class="text-gray-500 text-sm">Estimated arrival on
                                        {{ \Carbon\Carbon::now()->monthName }}
                                        {{ \Carbon\Carbon::now()->addDay(7)->day . ' - ' . \Carbon\Carbon::now()->addDay(9)->day }}
                                    </p>
                                </div>
                                <div class="p-3 cursor-pointer hover:bg-gray-100"
                                    @click="selected = 'premium'; open = false; @this.shippingMethod = 'premium'; @this.shippingCost = 100000">
                                    <p class="font-semibold">Premium (Rp100.000)</p>
                                    <p class="text-gray-500 text-sm">Estimated arrival on
                                        {{ \Carbon\Carbon::now()->monthName }}
                                        {{ \Carbon\Carbon::now()->addDay(4)->day . ' - ' . \Carbon\Carbon::now()->addDay(6)->day }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mt-3 ml-4">
                            <x-heroicon-s-shield-check class="w-5 h-5 text-gray-600" />
                            <p class="text-gray-700">Protected by shipping insurance</p>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center gap-2" x-data="{ note: '', maxLength: 30 }">
                        <x-heroicon-c-pencil-square class="size-6 text-gray-600" />
                        <input type="text" placeholder="Note to seller"
                            class="border border-gray-300 rounded-md px-3 py-1 w-full bg-transparent"
                            wire:model="note_to_seller" x-model="note" x-on:input="note = note.slice(0, maxLength)"
                            ::disabled="note.length >= 30" />
                        <span class="text-gray-400 ml-auto" x-text="note.length + '/30'"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-4">
            <div class="bg-gray-100 rounded-xl p-6 flex flex-col gap-6">
                <div x-data="{ showAll: false }">
                    <h3 class="text-gray-500 font-semibold uppercase text-sm mb-4">Payment Method</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-200 cursor-pointer hover:border-mainGreen transition">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri" class="w-8 h-8" />
                            <span class="text-gray-700 font-medium">Mandiri Virtual Account</span>
                            <input type="radio" name="payment" class="ml-auto" value="MANDIRI" wire:model="payment_method" />
                        </label>

                        <div x-show="showAll" x-transition class="space-y-3">
                            <label class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-200 cursor-pointer hover:border-mainGreen transition">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/f/f0/Bank_Negara_Indonesia_logo_%282004%29.svg" alt="BNI" class="w-8 h-8" />
                                <span class="text-gray-700 font-medium">BNI Virtual Account</span>
                                <input type="radio" name="payment" class="ml-auto" value="BNI" wire:model="payment_method" />
                            </label>
                        </div>
                        <div x-show="showAll" x-transition class="space-y-3">
                            <label class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-200 cursor-pointer hover:border-mainGreen transition">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg"
                                    alt="BCA" class="w-8 h-8" />
                                <span class="text-gray-700">BCA Virtual Account</span>
                                <input type="radio" name="payment" class="ml-auto" value="BCA"
                                    wire:model="payment_method" />
                            </label>
                        </div>
                        <div x-show="showAll" x-transition class="space-y-3">
                            <label class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-200 cursor-pointer hover:border-mainGreen transition">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/6/68/BANK_BRI_logo.svg"
                                    alt="BRI" class="w-8 h-8" />
                                <span class="text-gray-700">BRI Virtual Account</span>
                                <input type="radio" name="payment" class="ml-auto" value="BRI"
                                    wire:model="payment_method" />
                            </label>
                        </div>

                        <button type="button" @click="showAll = !showAll"
                            class="w-full py-2 text-sm text-gray-500 flex items-center justify-center gap-1 hover:text-mainGreen transition-colors">
                            <span x-text="showAll ? 'Show Less' : 'See Other Payment Methods'"></span>
                            <x-heroicon-s-chevron-down
                                class="size-4 transition-transform duration-300"
                                x-bind:class="showAll ? 'rotate-180' : ''" />
                        </button>
                        @error('payment_method')
                        <span class="text-xs text-red-500 block mt-2">Please select the payment method first.</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
                <h3 class="text-gray-800 font-bold mb-4 text-lg">Shopping Summary</h3>

                <div class="space-y-3 text-gray-700 text-sm">
                    <div class="flex justify-between">
                        <span x-text="'Total Price ('+@this.quantity+' Product)'"></span>
                        <span x-text="new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(@this.totalPrice)"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total shipping costs</span>
                        <span x-text="new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(@this.shippingCost || 20000)"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total shipping insurance</span>
                        <span>Rp20.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Application service charge</span>
                        <span>Rp5.000</span>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mt-2">
                        <div class="flex justify-between items-center font-bold text-base">
                            <span class="text-gray-900">Total Bill</span>
                            <span class="text-ecstasy-500 text-lg"
                                x-text="new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(Number(@this.totaled) + Number(@this.totalPrice) + Number(@this.shippingCost))"></span>
                        </div>
                    </div>
                </div>

                <button class="bg-ecstasy-500 text-white mt-6 w-full py-3 rounded-xl font-bold hover:bg-ecstasy-600 transition shadow-lg shadow-ecstasy-100"
                    wire:click="checkout">
                    Pay Now!
                </button>
            </div>
        </div>

        <x-modal name="change-address" :show="false" title="Select Shipping Address" :withIcon="false">
            <div class="p-4 flex flex-col gap-4">
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @foreach ($user_alamat as $alamat)
                    <div class="p-4 border rounded-xl cursor-pointer hover:border-mainGreen transition {{ $shipping_address == $alamat->alamat ? 'border-mainGreen bg-green-50' : 'border-gray-200' }}"
                        @click="$wire.selectAddress('{{ $alamat->id }}'); $dispatch('close-modal', 'change-address')">
                        <div class="flex items-start gap-3">
                            <x-heroicon-s-map-pin class="size-5 text-mainGreen mt-1" />
                            <div>
                                <h5 class="font-bold">{{ $alamat->nama }}</h5>
                                <p class="text-sm text-gray-600">{{ $alamat->alamat }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <button @click="$dispatch('close-modal', 'change-address'); setTimeout(() => $dispatch('open-modal', 'add-new-address'), 100)"
                    class="w-full flex items-center justify-center gap-2 py-3 border-2 border-dashed border-gray-300 rounded-xl text-gray-500 hover:border-mainGreen hover:text-mainGreen transition">
                    <x-heroicon-o-plus class="size-5" />
                    <span class="font-medium">Add New Shipping Address</span>
                </button>
            </div>
        </x-modal>
        <x-modal name="add-new-address" title="Add New Address">
            <div class="p-4 flex flex-col gap-4">
                <div>
                    <x-input.text label="Address Name (e.g., Home, Office)" wire:model="shipping_address_name_input" />
                    @error('shipping_address_name_input') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-input.text label="Full Address" wire:model="shipping_address_input" />
                    @error('shipping_address_input') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <x-button type="outline-neutral" @click="$dispatch('close-modal', 'add-new-address')">Cancel</x-button>
                    <x-button type="primary" wire:click="updateAddress">Save Address</x-button>
                </div>
            </div>
        </x-modal>
    </div>