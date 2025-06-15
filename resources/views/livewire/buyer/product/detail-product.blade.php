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
        <div class="grid grid-cols-2 gap-16 mt-4 w-full" x-data="{ activeTab: 'product' }">
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
                    <img src="{{ asset('images/mountain-placeholder.jpg') }}" alt="Card Image"
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
                    <button @click="activeTab = 'product'"
                        :class="{ 'text-mainGreen': activeTab === 'product', 'text-gray-500': activeTab !== 'product' }"
                        class="text-sm font-semibold hover:text-mainGreen transition">Product
                        By</button>
                    <button @click="activeTab = 'description'"
                        :class="{ 'text-mainGreen': activeTab === 'description', 'text-gray-500': activeTab !== 'description' }"
                        class="text-sm font-semibold hover:text-mainGreen transition">Description</button>
                    <button @click="activeTab = 'specifications'"
                        :class="{ 'text-mainGreen': activeTab === 'specifications', 'text-gray-500': activeTab !== 'specifications' }"
                        class="text-sm font-semibold hover:text-mainGreen transition">Specifications</button>
                </div>

                <div class="mt-4">
                    <!-- Product By Tab Content -->
                    <div x-show="activeTab === 'product'" class="transition-all duration-300">
                        <div
                            class="bg-blue-900 text-white font-bold py-4 px-8 rounded-xl flex justify-center items-center w-3/4 mb-4">
                            <span class="text-lg tracking-wide">{{ $product->seller->company_name }}<sup
                                    class="text-xs">&reg;</sup></span>
                        </div>

                    </div>

                    <!-- Description Tab Content -->
                    <div x-show="activeTab === 'description'" class="transition-all duration-300" x-cloak>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-semibold mb-2">Product Description</h3>
                            <p>{{ $product->deskripsi ?? 'No description available for this product.' }}</p>
                        </div>
                    </div>

                    <!-- Specifications Tab Content -->
                    <div x-show="activeTab === 'specifications'" class="transition-all duration-300" x-cloak>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-semibold mb-2">Product Specifications</h3>
                            @if ($product->specifications)
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach (json_decode($product->specifications) as $key => $value)
                                        <li><span class="font-medium">{{ $key }}:</span> {{ $value }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No specifications available for this product.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
