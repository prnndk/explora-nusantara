<x-layouts.dashboard webTitle="Transaction">
    <h1 class="text-4xl font-bold">Transaction#{{$transaction->id}}</h1>
    <div class="flex flex-row gap-6 items-center mt-4">
        <p>Duration</p>
        <x-table.transaction-badge :status="$transaction->status"/>
    </div>

    <div class="my-10">
        <livewire:seller.transaction.detail-transaction :transaction="$transaction"/>
    </div>
</x-layouts.dashboard>
