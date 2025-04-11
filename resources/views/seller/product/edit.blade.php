<x-layouts.dashboard webTitle="Product">
    <h1 class="text-4xl font-bold">Product#{{$product->id}}</h1>
    <p class="text-md mb-6 my-2">Added on {{\Carbon\Carbon::make($product->created_at)->monthName.', '. \Carbon\Carbon::make($product->created_at)}}</p>

    <livewire:seller.product.edit :product="$product"/>
</x-layouts.dashboard>
