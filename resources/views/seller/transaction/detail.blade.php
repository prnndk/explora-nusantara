<x-layouts.dashboard webTitle="Transaction">
    <div class="flex gap-2">
        <a href="{{ route('seller.transaction.index') }}" wire:navigate class="mt-1">
            <x-heroicon-o-arrow-left-circle class="size-8" />
        </a>
        <div>
            <h1 class="text-4xl font-bold">Transaction#{{ $transaction->id }}</h1>
            <div class="flex flex-row gap-6 items-center mt-4">
                <p>Duration</p>
                <x-table.transaction-badge :status="$transaction->status" />
            </div>
        </div>
    </div>

    <div class="my-10">
        <livewire:seller.transaction.detail-transaction :transaction="$transaction" />
    </div>

    


</x-layouts.dashboard>
