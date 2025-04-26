<div>
    <div class="flex gap-2">
        <a href="{{ route('buyer.product.index') }}" wire:navigate class="mt-1">
            <x-heroicon-o-arrow-left-circle class="size-8" />
        </a>
        <div>
            <h1 class="text-4xl font-bold">Detail Product</h1>
            <p>Everything you need to know about this product is here. Be sure to read the product description and
                specifications.</p>
        </div>
    </div>

    <section class="mt-4 mx-10">
        <h6 class="font-semibold">{{ $product->nama }}</h6>
        <div class="grid grid-cols-2 gap-16 mt-4 w-full">
            <div class="flex flex-col">
                @if ($product->file)
                    <img src="/view-file/{{ $product->file->id }}" alt="Card Image"
                        class="max-w-full h-64 object-cover rounded-md shadow-md">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 mt-3 mb-8">
                        <img src="/view-file/{{ $product->file->id }}" alt="Card Image"
                            class="max-w-full h-fit object-cover rounded-sm shadow-sm">
                        <img src="/view-file/{{ $product->file->id }}" alt="Card Image"
                            class="max-w-full h-fit object-cover rounded-sm shadow-sm">
                        <img src="/view-file/{{ $product->file->id }}" alt="Card Image"
                            class="max-w-full h-fit object-cover rounded-sm shadow-sm">
                        <img src="/view-file/{{ $product->file->id }}" alt="Card Image"
                            class="max-w-full h-fit object-cover rounded-sm shadow-sm">
                    </div>
                @else
                    <img src="{{ asset('images/mountain-placeholder.png') }}" alt="Card Image"
                        class="max-w-full h-64 object-cover rounded-md shadow-md">
                @endif

                <div class="flex flex-col gap-1">
                    <p class="text-sm font-semibold"><span class="text-blue-500">Min. Order :</span> 12 Unit</p>
                    <p class="text-sm font-semibold"><span class="text-blue-500">International Commercial Terms :</span>
                        FOB</p>
                    <p class="text-sm font-semibold"><span class="text-blue-500">Stock :</span> {{ $product->stok }}</p>
                </div>
                <div class="flex justify-end my-3">
                    <p class="text-xl font-semibold text-ecstasy-500">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                </div>

                <a href="{{ route('buyer.product.checkout', $product->id) }}" wire:navigate>
                    <x-button type="primary" addClasses="w-full">
                        Order
                    </x-button>
                </a>
            </div>
            <div class="flex flex-col gap-3 w-full">
                <div class="flex flex-row gap-8">
                    <a href="" class="text-sm text-mainGreen font-semibold">Product By</a>
                    <a href="" class="text-sm text-gray-500 font-semibold">Description</a>
                    <a href="" class="text-sm text-gray-500 font-semibold">Spesifications</a>
                </div>
                <div
                    class="bg-blue-900 text-white font-bold py-4 px-8 rounded-xl flex justify-center items-center w-3/4">
                    <span class="text-lg tracking-wide">{{ $product->seller->company_name }}<sup
                            class="text-xs">&reg;</sup></span>
                </div>
            </div>
        </div>
    </section>
</div>
