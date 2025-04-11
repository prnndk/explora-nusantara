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
            </div>
            <div class="flex flex-col space-y-6 gap-4">
                <h6 class="font-semibold text-2xl mb-6">Transaction Detail</h6>
                <x-input.text label="Product Quantity" name="product_quantity"
                              :transparent="false" value="10" readonly/>
                <x-input.text label="Total Price" name="total_price"
                              :transparent="false"
                              value="Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}" readonly/>
            </div>
        </div>
    </section>
</div>

