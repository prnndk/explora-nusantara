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

    <section class="mt-8 mx-10">
        <div class="grid grid-cols-12 gap-12">

            <div class="col-span-5" x-data="{ 
    images: [
        // Gallery dimasukin duluan
        @foreach($product->images as $img) '{{ route('product-image', $img->id) }}', @endforeach
        // Cover ditaruh terakhir di array
        '/view-file/{{ $product->file->id }}', 
    ],
    {{-- 
        Karena images.length index-nya mulai dari 0, 
        supaya yang muncul pertama kali yang paling terakhir (si cover), 
        kita set activeIndex ke index terakhir.
    --}}
    activeIndex: null,
    init() { this.activeIndex = this.images.length - 1 },
    
    next() { this.activeIndex = (this.activeIndex + 1) % this.images.length },
    prev() { this.activeIndex = (this.activeIndex - 1 + this.images.length) % this.images.length }
}">
                <div class="sticky top-6">
                    <div class="relative group">
                        {{-- Tambahkan x-if atau check agar tidak error saat init --}}
                        <template x-if="activeIndex !== null">
                            <img :src="images[activeIndex]"
                                class="w-full h-[400px] object-cover rounded-2xl shadow-sm border transition-all duration-500">
                        </template>

                        <button @click="prev()"
                            class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/40 backdrop-blur-md p-3 rounded-full shadow-xl 
    hover:bg-white hover:scale-110 opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <x-heroicon-o-chevron-left class="size-6 text-gray-900" />
                        </button>

                        <button @click="next()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/40 backdrop-blur-md p-3 rounded-full shadow-xl 
    hover:bg-white hover:scale-110 opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <x-heroicon-o-chevron-right class="size-6 text-gray-900" />
                        </button>
                    </div>

                    <div class="flex gap-3 mt-4 overflow-x-auto pb-2 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none] scroll-smooth snap-x">
                        <template x-for="(img, index) in images" :key="index">
                            <img :src="img"
                                @click="activeIndex = index"
                                :class="activeIndex === index 
            ? 'border-mainGreen ring-4 ring-mainGreen/20 scale-105 z-10' 
            : 'border-transparent opacity-60 hover:opacity-100 grayscale hover:grayscale-0'"
                                class="w-20 h-20 flex-shrink-0 object-cover rounded-xl cursor-pointer border-2 transition-all duration-300 snap-center shadow-sm">
                        </template>
                    </div>
                </div>
            </div>

            <div class="col-span-7 flex flex-col">
                <h1 class="text-3xl font-bold text-gray-800">{{ $product->nama }}</h1>

                <div class="mt-4 flex items-baseline gap-4">
                    <span class="text-3xl font-bold text-ecstasy-500">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    <span class="text-gray-500 text-sm">/ Unit</span>
                </div>

                <div class="mt-6 p-5 bg-gray-50 rounded-2xl border border-gray-100 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Stock Available</span>
                        <span class="font-semibold text-gray-900">{{ $product->stok }} Units</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Incoterms</span>
                        <span class="font-semibold text-gray-900">FOB</span>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('buyer.product.checkout', $product->id) }}" wire:navigate>
                        <x-button type="primary"
                            addClasses="w-full py-4 text-lg rounded-xl shadow-lg shadow-ecstasy-500/20 
    transition-all duration-300 transform hover:-translate-y-1 hover:shadow-ecstasy-500/40 
    active:scale-95 focus:ring-4 focus:ring-ecstasy-500/30">
                            Proceed to Order
                        </x-button>
                    </a>
                </div>

                <div class="mt-10" x-data="{ activeTab: 'description' }">
                    <div class="flex border-b border-gray-200 gap-8">
                        <button @click="activeTab = 'description'"
                            :class="activeTab === 'description' 
        ? 'border-b-2 border-mainGreen text-mainGreen' 
        : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                            class="pb-3 px-4 text-sm font-bold transition-all duration-200 rounded-t-lg">
                            Description
                        </button>
                        <button @click="activeTab = 'specifications'" :class="activeTab === 'specifications' ? 'border-b-2 border-mainGreen text-mainGreen' : 'text-gray-500'" class="pb-3 text-sm font-bold">Specifications</button>
                        <button @click="activeTab = 'seller'" :class="activeTab === 'seller' ? 'border-b-2 border-mainGreen text-mainGreen' : 'text-gray-500'" class="pb-3 text-sm font-bold">Seller Info</button>
                    </div>

                    <div class="py-6 text-gray-600 leading-relaxed">
                        <div x-show="activeTab === 'description'" x-cloak>
                            <p class="whitespace-pre-line text-gray-700 leading-relaxed">
                                {{ $product->deskripsi ?? 'No description available for this product.' }}
                            </p>
                        </div>
                        <div x-show="activeTab === 'specifications'" x-cloak>
                            @if ($product->specifications && count(json_decode($product->specifications, true)) > 0)
                            <div class="overflow-hidden border border-gray-100 rounded-xl">
                                <table class="w-full text-sm text-left">
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach (json_decode($product->specifications) as $key => $value)
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="px-4 py-3 font-medium text-gray-500 w-1/3 bg-gray-50/50">{{ $key }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $value }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="flex flex-col items-center justify-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                <x-heroicon-o-clipboard-document-list class="size-12 text-gray-300 mb-2" />
                                <p class="text-gray-500 italic text-sm">No specifications available for this product.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div x-show="activeTab === 'seller'" x-cloak>
                        <p class="font-bold text-blue-900">{{ $product->seller->company_name }}</p>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>