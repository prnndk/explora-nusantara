<div>
    <h1 class="text-4xl font-bold">Product</h1>
    <p>Welcome to our product page! Explore a wide range of options designed specifically to provide the solutions
        you're looking for.</p>

    <div class="flex flex-col gap-8 mt-10">
        <div class="flex items-center justify-between flex-wrap gap-4">

            <h5 class="font-semibold text-lg border-b-4 border-mainGreen pb-1">
                Category
            </h5>

            <div class="relative w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <x-heroicon-m-magnifying-glass class="w-5 h-5 text-gray-400" />
                </div>

                <input
                    type="search"
                    wire:model.live="search"
                    placeholder="Search product..."
                    class="w-full pl-10 pr-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-mainGreen focus:outline-none" />
            </div>

        </div>


        <div class="flex flex-wrap gap-2 mb-4">

            <button
                wire:click="filterCategory(null)"
                class="px-4 py-1.5 text-sm rounded-lg border transition
            {{ $category == null ? 'bg-mainGreen text-white border-mainGreen' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                All
            </button>

            @foreach($categories as $cat)
            <button
                wire:click="filterCategory('{{ $cat->id }}')"
                class="px-4 py-1.5 text-sm rounded-lg border transition
                {{ $category == $cat->id ? 'bg-mainGreen text-white border-mainGreen' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                {{ $cat->name }}
            </button>
            @endforeach
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
                            {{ Str::limit($product->deskripsi, 50) }}
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