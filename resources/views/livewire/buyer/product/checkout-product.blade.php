<div>
    <div class="flex gap-2 mb-6">
        <a href="" class="mt-1">
            <x-heroicon-o-arrow-left-circle class="size-8"/>
        </a>
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
                        <div class="flex flex-col gap-3">
                            <div class="flex flex-row gap-3 items-center">
                                <x-heroicon-s-map-pin class="size-6 text-mainGreen"/>
                                <p class="font-semibold">Rumah {{auth()->user()->buyer->name}}</p>
                            </div>
                            <p class="text-gray-700">{{$shipping_address}}</p>
                        </div>
                    </div>
                </div>
                <button x-on:click="$dispatch('open-modal', 'change-address')"
                        class="border border-gray-300 text-gray-500 rounded-md px-3 py-1 text-sm hover:bg-gray-200">
                    Change
                </button>

            </div>
            <div class="bg-gray-100 rounded-xl p-4 flex gap-4">
                <img src="/view-file/{{ $product->file->id }}" alt="Product Image"
                     class="w-24 h-24 rounded-lg object-cover"/>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-lg">{{$product->nama}}</h3>
                            <p class="text-gray-500 text-sm">NORMAL</p>
                            <div class="flex items-center gap-2 mt-4">
                                <x-heroicon-s-building-office class="w-5 h-5 text-mainGreen"/>
                                <p class="text-gray-700">{{$product->seller->company_name}}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center gap-2"
                             x-data="{ quantity: @this.quantity, harga: {{$product->harga}} }"
                        >
                            <p class="font-semibold text-gray-900"
                            >
                                {{ 'Rp' . number_format($product->harga, 0, ',', '.') }}
                            </p>

                            <div class="flex justify-center">
                                <div
                                    class="flex items-center gap-2 px-2 py-1"
                                >
                                    <button
                                        type="button"
                                        @click="if(quantity > 1) { quantity--; @this.quantity = quantity ; @this.totalPrice = quantity * harga }"
                                        class="text-gray-500 transition hover:text-red-600"
                                        :disabled="quantity <= 1"
                                        :class="{ 'opacity-50 cursor-not-allowed': quantity <=1 }"
                                    >
                                        <x-heroicon-o-minus-circle class="w-7 h-7"/>
                                    </button>

                                    <span class="px-4 text-center" x-text="quantity"></span>

                                    <button
                                        type="button"
                                        x-on:click="quantity++; @this.quantity = quantity ; @this.totalPrice = quantity * harga"
                                        class="text-gray-500 transition hover:text-green-600"
                                    >
                                        <x-heroicon-o-plus-circle class="w-7 h-7"/>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 border border-gray-300 rounded-lg p-3">
                        <div class="m-4 p-4">
                            <p class="font-semibold">Economic (Rp200.000)</p>
                            <p class="text-gray-500 text-sm">Estimated arrival on {{\Carbon\Carbon::now()->monthName}} {{\Carbon\Carbon::now()->addDay(5)->day . ' - '. \Carbon\Carbon::now()->addDay(10)->day}}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <x-heroicon-s-shield-check class="w-5 h-5 text-gray-600"/>
                                <p class="text-gray-700">Protected by shipping insurance</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center gap-2" x-data="{note: '', maxLength: 30}">
                        <x-heroicon-c-pencil-square class="size-6 text-gray-600"/>
                        <input type="text" placeholder="Note to seller"
                               class="border border-gray-300 rounded-md px-3 py-1 w-full bg-transparent"
                               wire:model="note_to_seller"
                               x-model="note"
                               x-on:input="note = note.slice(0, maxLength)"
                               ::disabled="note.length >= 30"
                        />
                        <span class="text-gray-400 ml-auto" x-text="note.length + '/30'"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-100 rounded-xl p-4 flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-gray-500 font-semibold uppercase text-sm">Payment Method</h3>
                <h6 class="text-mainGreen cursor-pointer">See all</h6>
            </div>

            <div class="space-y-3 mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg"
                         alt="Mandiri" class="w-8 h-8"/>
                    <span class="text-gray-700">Mandiri Virtual Account</span>
                    <input type="radio" name="payment" class="ml-auto" value="MANDIRI" wire:model="payment_method"/>
                </label>

                <label class="flex items-center gap-3 cursor-pointer">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA"
                         class="w-8 h-8"/>
                    <span class="text-gray-700">BCA Virtual Account</span>
                    <input type="radio" name="payment" class="ml-auto" value="BCA" wire:model="payment_method"/>
                </label>
            </div>

            <div class="mb-6">
                <h4 class="text-gray-500 font-semibold uppercase text-sm mb-3">Detail</h4>
                <div class="space-y-2 text-gray-700">
                    <div class="flex justify-between">
                        <span x-text="'Total Price ('+@this.quantity+' Product)'"></span>
                        <span
                            x-text="new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(@this.totalPrice)"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total shipping costs</span>
                        <span>Rp200.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total shipping insurance</span>
                        <span>Rp20.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Application service charge</span>
                        <span>Rp5.000</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-300 pt-4 mb-4">
                <div class="flex justify-between items-center font-semibold">
                    <span x-init="@this.totaled += parseFloat(@this.totalPrice);" >Total</span>
                    <span class="text-gray-900"
                          x-text="new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(@this.totaled)"></span>
                </div>
            </div>
            <button class="bg-ecstasy-500 text-white mt-4 w-full py-3 rounded-lg hover:bg-ecstasy-600" wire:click="checkout" >Pay Now!</button>
        </div>
    </div>
    <x-modal name="change-address" :show="false" title="Change Address">
        <div class="p-3 flex flex-col gap-4">
            <div
                class="relative w-full rounded-lg border bg-white p-4 [&>svg]:absolute [&>svg]:text-foreground [&>svg]:left-4 [&>svg]:top-4 [&>svg+div]:translate-y-[-3px] [&:has(svg)]:pl-11 text-neutral-900">
                <x-heroicon-s-map-pin class="size-4"/>

                <h5 class="mb-1 font-medium leading-none tracking-tight">Rumah {{auth()->user()->buyer->name}} </h5>
                <p class="text-sm opacity-70">{{auth()->user()->buyer->address}}</p>
            </div>

            <div class="flex flex-col gap-2">
                <x-input.text label="Shipping Address" :required="true" name="shipping_address"
                              :transparent="false" wire:model="shipping_address"/>
                <p class="text-sm text-gray-500">Please enter your address for shipping. If u want to change</p>
            </div>

            <div class="flex justify-end gap-2">
                <x-button type="outline-neutral" @click="$dispatch('close-modal', 'change-address')">
                    Cancel
                </x-button>
                <x-button type="primary" wire:click="updateAddress" wire:loading.attr="disabled">
                    Save
                </x-button>
            </div>
        </div>
    </x-modal>
</div>
