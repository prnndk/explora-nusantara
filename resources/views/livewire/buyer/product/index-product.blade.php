<div>
    <h1 class="text-4xl font-bold">Product</h1>
    <p>Welcome to our product page! Explore a wide range of options designed specifically to provide the solutions
        you're looking for.</p>

    <div class="flex flex-col gap-8 mt-10">
        <div class="flex flex-row justify-between w-full">
            <h5 class="underline underline-offset-8 decoration-4 decoration-mainGreen font-bold">Category</h5>

            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <x-heroicon-m-magnifying-glass class="w-6 h-6 text-gray-500"/>
                </div>
                <input type="search"
                       class="block w-full p-2 px-7 ps-10 text-sm text-gray-600 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Search Product" wire:model.live="search" required/>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <a wire:navigate href="{{route('buyer.product.detail',  $product->id)}}">

                    <div
                        class="max-w-sm lg:max-w-md bg-white rounded-2xl shadow-md overflow-hidden min-h-[500px] flex flex-col">
                        @if($product->file)
                            <img src="/view-file/{{ $product->file->id }}" alt="Card Image" class="w-full h-56 object-cover">
                        @else
                            <img src="{{ asset('images/mountain-placeholder.jpg') }}" alt="Card Image" class="w-full h-56 object-cover">
                        @endif
                        <div class="p-6 flex flex-col justify-between flex-grow">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->nama }}</h2>
                                <p class="text-gray-600 mb-6">
                                    {{$product->deskripsi}}
                                </p>
                                <div class="flex items-center gap-2 mb-4">
                                    <span
                                        class="bg-yellow-200 text-gray-800 text-sm font-medium px-3 py-1 rounded-full">New</span>
                                    <span class="bg-pink-200 text-gray-800 text-sm font-medium px-3 py-1 rounded-full">Popular</span>
                                </div>
                            </div>
                            <p class="text-gray-600 mt-auto">Stock: <span
                                    class="{{$product->stok < 5 ? 'text-red-600' : 'text-green-600'}} font-semibold">{{$product->stok}}</span>
                            </p>
                        </div>
                    </div>
                </a>

            @endforeach
        </div>
        {{$products->links('components.pagination-link')}}
    </div>
</div>
