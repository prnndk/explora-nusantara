<x-layouts.dashboard webTitle="Detail Product">
    <div class="flex gap-2">
        <a href="" class="mt-1"><x-heroicon-o-arrow-left-circle class="size-8" /></a>
        <div>
            <h1 class="text-4xl font-bold">Detail Product</h1>
            <p>Everything you need to know about this product is here. Be sure to read the product description and
                specifications.</p>
        </div>
    </div>

    <section class="mt-4 mx-10">
        <h6 class="font-semibold">The Coldest Sunset</h6>
        <div class="flex flex-row gap-16 mt-4 w-full">
            <div class="flex flex-col">
                <img src="{{ asset('images/mountain-placeholder.jpg') }}" alt="Card Image"
                    class="w-full h-48 object-cover rounded-md shadow-md">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 mt-3 mb-8">
                    <img src="{{ asset('images/mountain-placeholder.jpg') }}" alt="Card Image"
                        class="w-20 h-20 object-cover rounded-sm shadow-sm">
                    <img src="{{ asset('images/mountain-placeholder.jpg') }}" alt="Card Image"
                        class="w-20 h-20 object-cover rounded-sm shadow-sm">
                    <img src="{{ asset('images/mountain-placeholder.jpg') }}" alt="Card Image"
                        class="w-20 h-20 object-cover rounded-sm shadow-sm">
                    <img src="{{ asset('images/mountain-placeholder.jpg') }}" alt="Card Image"
                        class="w-20 h-20 object-cover rounded-sm shadow-sm">
                </div>

                <div class="flex flex-col gap-1">
                    <p class="text-sm font-semibold"><span class="text-blue-500">Min. Order :</span> 12 Unit</p>
                    <p class="text-sm font-semibold"><span class="text-blue-500">International Commercial Terms :</span>
                        FOB</p>
                    <p class="text-sm font-semibold"><span class="text-blue-500">Stock :</span> 10000</p>
                </div>
                <div class="flex justify-end my-3">
                    <p class="text-xl font-semibold text-ecstasy-500">Rp 40.000</p>
                </div>

                <x-button type="primary" addClasses="w-full">
                    Order
                </x-button>
            </div>
            <div class="flex flex-col gap-3 w-full">
                <div class="flex flex-row gap-8">
                    <a href="" class="text-sm text-mainGreen font-semibold">Product By</a>
                    <a href="" class="text-sm text-gray-500 font-semibold">Description</a>
                    <a href="" class="text-sm text-gray-500 font-semibold">Spesifications</a>
                </div>
                <div
                    class="bg-blue-900 text-white font-bold py-4 px-8 rounded-xl flex justify-center items-center w-3/4">
                    <span class="text-lg tracking-wide">ventela<sup class="text-xs">&reg;</sup></span>
                </div>
            </div>

        </div>
    </section>
</x-layouts.dashboard>
