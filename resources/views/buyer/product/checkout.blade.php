<x-layouts.app-white webTitle="Checkout Page">
    <div class="flex gap-2 mb-6">
        <a href="" class="mt-1"><x-heroicon-o-arrow-left-circle class="size-8" /></a>
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
                                <x-heroicon-s-map-pin class="size-6 text-mainGreen" />
                                <p class="font-semibold">Rumah John Doe</p>
                            </div>
                            <p class="text-gray-700">Jalan Surabaya No. 100, Keputih, Surabaya, Jawa Timur, 60111</p>
                        </div>
                    </div>
                </div>
                <button
                    class="border border-gray-300 text-gray-500 rounded-md px-3 py-1 text-sm hover:bg-gray-200">Change</button>
            </div>
            <div class="bg-gray-100 rounded-xl p-4 flex gap-4">
                <img src="{{ asset('images/mountain-placeholder.jpg') }}" alt="Product Image"
                    class="w-16 h-16 rounded-lg object-cover" />
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-lg">The Coldest Sunset</h3>
                            <p class="text-gray-500 text-sm">NORMAL</p>
                            <div class="flex items-center gap-2 mt-4">
                                <x-heroicon-s-building-office class="w-5 h-5 text-mainGreen" />
                                <p class="text-gray-700">PT. Ventela</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center gap-2">
                            <p class="font-semibold text-gray-900">Rp40.000</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center px-2 py-1">
                                    <x-heroicon-o-minus-circle class="text-gray-500 size-5" />
                                    <span class="px-4">2</span>
                                    <x-heroicon-o-plus-circle class="text-gray-500 size-5" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 border border-gray-300 rounded-lg p-3">
                        <div class="m-4 p-4">
                            <p class="font-semibold">Economic (Rp5.000)</p>
                            <p class="text-gray-500 text-sm">Estimated arrival on January 10-11</p>
                            <div class="flex items-center gap-2 mt-2">
                                <x-heroicon-s-shield-check class="w-5 h-5 text-gray-600" />
                                <p class="text-gray-700">Protected by shipping insurance</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center gap-2">
                        <x-heroicon-c-pencil-square class="size-6 text-gray-600" />
                        <input type="text" placeholder="Note to seller"
                            class="border border-gray-300 rounded-md px-3 py-1 w-full bg-transparent" />
                        <span class="text-gray-400 ml-auto">0/300</span>
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
                        alt="Mandiri" class="w-8 h-8" />
                    <span class="text-gray-700">Mandiri Virtual Account</span>
                    <input type="radio" name="payment" class="ml-auto" />
                </label>

                <label class="flex items-center gap-3 cursor-pointer">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA"
                        class="w-8 h-8" />
                    <span class="text-gray-700">BCA Virtual Account</span>
                    <input type="radio" name="payment" class="ml-auto" />
                </label>
            </div>

            <div class="mb-6">
                <h4 class="text-gray-500 font-semibold uppercase text-sm mb-3">Detail</h4>
                <div class="space-y-2 text-gray-700">
                    <div class="flex justify-between">
                        <span>Total Price (2 Product)</span>
                        <span>Rp80.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total shipping costs</span>
                        <span>Rp5.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total shipping insurance</span>
                        <span>Rp200</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Application service charge</span>
                        <span>Rp5.000</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-300 pt-4 mb-4">
                <div class="flex justify-between items-center font-semibold">
                    <span>Total</span>
                    <span class="text-gray-900">Rp90.200</span>
                </div>
            </div>
            <button class="bg-ecstasy-500 text-white mt-4 w-full py-3 rounded-lg hover:bg-ecstasy-600">Pay Now!</button>
        </div>
    </div>
</x-layouts.app-white>
