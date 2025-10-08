<div>
    <section class="mt-4 mx-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 mt-4 w-full">
            <div class="flex flex-col space-y-6 gap-4">
                <h6 class="font-semibold text-2xl mb-6">Product Detail</h6>
                <x-input.text label="Product Name" name="product_name"
                              :transparent="false" value="{{$transaction->product->nama}}" readonly/>
                <p class="font-semibold ">Image</p>
                <img src="/view-file/{{ $transaction->product->foto_file_id }}" alt="Card Image"
                     class="max-w-full h-64 object-cover rounded-md shadow-md">
                <h6 class="font-semibold text-2xl my-6">Seller Detail</h6>
                <x-input.text label="Seller Full Name" name="seller_name"
                              :transparent="false" value="{{$transaction->seller->name}}" readonly/>
                <x-input.text label="Company Name" name="company_name"
                              :transparent="false" value="{{$transaction->seller->company_name}}" readonly/>
                <h6 class="font-semibold text-2xl my-6">Buyer Detail</h6>
                <x-input.text label="Seller Full Name" name="seller_name"
                              :transparent="false" value="{{$transaction->buyer->name}}" readonly/>
                <x-input.text label="Company Name" name="company_name"
                              :transparent="false" value="{{$transaction->buyer->company_name}}" readonly/>
            </div>
            <div class="flex flex-col space-y-6 gap-4">
                <h6 class="font-semibold text-2xl mb-6">Transaction Detail</h6>
                <x-input.text label="Product Quantity" name="product_quantity"
                              :transparent="false" value="10" readonly/>
                <x-input.text label="Total Price" name="total_price"
                              :transparent="false"
                              value="Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}" readonly/>
                <h6 class="font-semibold text-2xl mb-6">Support Files</h6>
                <div>
                    <span class="block mb-2 text-sm tracking-wide text-gray-500">Contract File</span>
                    <div x-data="{ dropdownOpen: false }" class="relative">

                        <button @click.prevent="dropdownOpen = true"
                                class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">
                            <x-heroicon-o-document class="w-5 h-5 mr-3"/>
                            Contract.pdf
                            <x-heroicon-c-ellipsis-vertical
                                class="w-5 h-5 ml-3"/>
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                             x-transition:enter="ease-out duration-200"
                             x-transition:enter-start="-translate-y-2"
                             x-transition:enter-end="translate-y-0"
                             class="absolute top-full left-0 mt-2 z-50 w-56"
                             x-cloak>
                            <div
                                class="p-1 mt-1 text-sm bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                                <a href="#_" @click="dropdownOpen = false"
                                   class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                    <span>Open File</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
