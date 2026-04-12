<div>
    <section class="mt-4 mx-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 mt-4 w-full">
            <div class="flex flex-col space-y-6 gap-4">
                <h6 class="font-semibold text-2xl mb-6">Product Detail</h6>
                <x-input.text label="Product Name" name="product_name"
                    :transparent="false" value="{{$transaction->product->nama}}" readonly />
                <p class="font-semibold" mt-6>Image</p>

                <div class="flex flex-col space-y-1" x-data="{ 
    images: [
        '/view-file/{{ $transaction->product->foto_file_id }}', 
        @foreach($transaction->product->images as $img) '{{ asset('storage/' . $img->image_path) }}', @endforeach
    ],
    activeIndex: 0 
}">
                    <div class="relative w-full aspect-video overflow-hidden rounded-xl border border-gray-100 shadow-sm bg-gray-50">
                        <img :src="images[activeIndex]"
                            class="w-full h-full object-cover transition-all duration-500">
                    </div>

                    <div class="flex gap-2 mt-1 overflow-x-auto pb-1 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none] snap-x">
                        <template x-for="(img, index) in images" :key="index">
                            <img :src="img"
                                @click="activeIndex = index"
                                :class="activeIndex === index ? 'border-mainGreen ring-2 ring-mainGreen/20' : 'border-gray-200'"
                                class="w-20 h-20 flex-shrink-0 object-cover rounded-lg cursor-pointer border-2 transition-all hover:opacity-80 snap-center">
                        </template>
                    </div>
                </div>
                <h6 class="font-semibold text-2xl my-6">Seller Detail</h6>
                <x-input.text label="Seller Full Name" name="seller_name"
                    :transparent="false" value="{{$transaction->seller->name}}" readonly />
                <x-input.text label="Company Name" name="company_name"
                    :transparent="false" value="{{$transaction->seller->company_name}}" readonly />
                <h6 class="font-semibold text-2xl my-6">Buyer Detail</h6>
                <x-input.text label="Seller Full Name" name="seller_name"
                    :transparent="false" value="{{$transaction->buyer->name}}" readonly />
                <x-input.text label="Company Name" name="company_name"
                    :transparent="false" value="{{$transaction->buyer->company_name}}" readonly />
            </div>
            <div class="flex flex-col space-y-6 gap-4">
                <h6 class="font-semibold text-2xl mb-6">Transaction Detail</h6>
                <x-input.text label="Product Quantity" name="product_quantity"
                    :transparent="false" value="10" readonly />
                <x-input.text label="Total Price" name="total_price"
                    :transparent="false"
                    value="Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}" readonly />
                <h6 class="font-semibold text-2xl mb-6">Support Files</h6>
                <div>
                    <span class="block mb-2 text-sm tracking-wide text-gray-500">Contract File</span>

                    {{-- Cek apakah kontrak ada --}}
                    @if($contract && $contract->file)
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click.prevent="dropdownOpen = true"
                            class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100">
                            <x-heroicon-o-document class="w-5 h-5 mr-3" />
                            Contract.pdf
                            <x-heroicon-c-ellipsis-vertical class="w-5 h-5 ml-3" />
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-cloak
                            class="absolute top-full left-0 mt-2 z-50 w-56">
                            <div class="p-1 mt-1 text-sm bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                                <a href="/view-file/{{ $contract->file->id }}" target="_blank"
                                    class="relative flex justify-between w-full cursor-pointer rounded px-2 py-1.5 hover:bg-neutral-100">
                                    <span>Open File</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                    {{-- Tampilan kalau kontrak belum ada --}}
                    <div class="flex items-center gap-2 p-3 text-sm text-amber-700 bg-amber-50 border border-amber-100 rounded-lg">
                        <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
                        <span>Kontrak belum tersedia untuk transaksi ini.</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>