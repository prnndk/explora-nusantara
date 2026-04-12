<div class="flex flex-row gap-2 items-center">
    @if($row->status !== \App\Enums\TransactionStatus::DONE && $row->status !== \App\Enums\TransactionStatus::CANCELED)
        
        {{-- Approve Button - hanya muncul kalau PENDING (kontrak sudah diupload) --}}
        @if($row->status === \App\Enums\TransactionStatus::PENDING)
        <div class="relative group flex items-center">
            <button
                x-on:click="$dispatch('open-modal', 'confirm-action-{{ $id }}')"
                class="flex items-center justify-center text-mainGreen hover:scale-110 transition-all duration-200">
                <x-heroicon-s-check-circle class="size-6"/>
            </button>
            <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition text-xs bg-gray-800 text-white px-2 py-1 rounded-md pointer-events-none whitespace-nowrap">
                Approve
            </div>
        </div>
        @endif

        {{-- Reject Button --}}
        <div class="relative group flex items-center">
            <button
                x-on:click="$dispatch('open-modal', 'confirm-delete-{{ $id }}')"
                class="flex items-center justify-center text-red-normal hover:text-red-dark transition-all duration-200 hover:scale-110">
                <x-heroicon-s-x-circle class="size-6"/>
            </button>
            <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition text-xs bg-gray-800 text-white px-2 py-1 rounded-md pointer-events-none whitespace-nowrap">
                Reject
            </div>
        </div>
    @endif

    {{-- See Detail Button --}}
    <div class="relative group flex items-center">
        <a href="{{ route('admin.transaction.detail', $id) }}" wire:navigate
           class="flex items-center justify-center text-amber-600 hover:text-amber-700 transition-all duration-200 hover:scale-110">
            <x-heroicon-s-information-circle class="size-6"/>
        </a>
        <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition text-xs bg-gray-800 text-white px-2 py-1 rounded-md pointer-events-none whitespace-nowrap">
            See Detail
        </div>
    </div>
</div>

{{-- Modal Approve --}}
@if($row->status === \App\Enums\TransactionStatus::PENDING)
<x-warning-modal name="confirm-action-{{$id}}" :show="false" title="Approve this transaction?">
    <div class="p-3 grid grid-cols-2 justify-between items-center gap-4">
        <button type="button" x-on:click="$dispatch('close-modal', 'confirm-action-{{$id}}')"
            class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-gray-700 border border-gray-700 rounded-lg hover:bg-gray-300">
            No
        </button>
        <button type="button" wire:click="approveTransaction('{{$id}}')"
            x-on:click="$dispatch('close-modal', 'confirm-action-{{$id}}')"
            class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white bg-mainGreen rounded-lg hover:bg-teal-700">
            Yes
        </button>
    </div>
</x-warning-modal>
@endif

{{-- Modal Reject --}}
<x-delete-modal name="confirm-delete-{{$id}}" :show="false" title="Cancel this transaction?">
    <div class="p-3 grid grid-cols-2 justify-between items-center gap-4">
        <button type="button" x-on:click="$dispatch('close-modal', 'confirm-delete-{{$id}}')"
            class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-red-normal border border-red-normal rounded-lg hover:bg-red-normal hover:text-white">
            No
        </button>
        <button type="button" wire:click="cancelTransaction('{{$id}}')"
            x-on:click="$dispatch('close-modal', 'confirm-delete-{{$id}}')"
            class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white bg-red-normal rounded-lg hover:bg-red-dark">
            Yes
        </button>
    </div>
</x-delete-modal>