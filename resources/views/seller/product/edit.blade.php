<x-layouts.dashboard webTitle="Product">
    <div class="flex gap-4">
        <a href="{{ route('seller.product.index') }}" wire:navigate class="mt-1">
            <x-heroicon-o-arrow-left-circle class="size-8" />
        </a>
        <div>
            <h1 class="text-4xl font-bold">Product#{{ $product->id }}</h1>
            <p class="text-md mb-6 my-2">Added on
                {{ \Carbon\Carbon::make($product->created_at)->monthName . ', ' . \Carbon\Carbon::make($product->created_at) }}
            </p>
        </div>
    </div>

    <livewire:seller.product.edit :product="$product" />
</x-layouts.dashboard>
