<div class="flex flex-row gap-2 items-center">
    {{-- Aksi Approve & Cancel hanya muncul jika status BUKAN Done atau Canceled --}}
    @if($row->status !== \App\Enums\TransactionStatus::DONE && $row->status !== \App\Enums\TransactionStatus::CANCELED)
        <button x-on:click="$dispatch('open-modal', 'confirm-action-{{ $id }}')" class="text-mainGreen hover:scale-110 transition">
            <x-heroicon-s-check-circle class="size-6"/>
        </button>
        
        <button x-on:click="$dispatch('open-modal', 'confirm-delete-{{ $id }}')"
            class="text-red-normal hover:text-red-dark hover:scale-110 transition">
            <x-heroicon-s-x-circle class="size-6"/>
        </button>
    @endif

    {{-- Tombol Detail selalu muncul --}}
    <a href="{{route('seller.transaction.detail',$id)}}" wire:navigate class="text-amber-600 hover:scale-110 transition">
        <x-heroicon-m-information-circle class="size-6"/>
    </a>
</div>

{{-- Modal Konfirmasi tetap di luar @if agar tidak error saat di-dispatch --}}
<x-warning-modal name="confirm-action-{{$id}}" :show="false" title="Are you sure want to approve this transaction?">
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

<x-delete-modal name="confirm-delete-{{$id}}" :show="false" title="Are you sure want to cancel this transaction?">
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