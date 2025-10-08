<div class="flex flex-row gap-2 items-center">

    {{-- Cancel Transaction --}}
    <button x-data="{ showTooltip: false }"
        @mouseenter="showTooltip = true"
        @mouseleave="showTooltip = false"
        x-on:click="$dispatch('open-modal', 'confirm-delete-{{ $id }}')"
        class="relative flex items-center justify-center p-2 rounded-lg text-red-normal hover:bg-gray-100 transition">
        <x-heroicon-s-x-circle class="w-6 h-6" />
        <span x-show="showTooltip"
              x-transition
              class="absolute -top-7 left-1/2 -translate-x-1/2 mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg whitespace-nowrap">
            Cancel Transaction
        </span>
    </button>

    {{-- Detail Transaction (warna oranye + solid icon) --}}
    <a href="{{ route('buyer.transaction.detail', $id) }}"
       wire:navigate
       x-data="{ showTooltip: false }"
       @mouseenter="showTooltip = true"
       @mouseleave="showTooltip = false"
       class="relative flex items-center justify-center p-2 rounded-lg text-yellow-normal hover:bg-gray-100 transition">
        <x-heroicon-s-information-circle class="w-6 h-6" />
        <span x-show="showTooltip"
              x-transition
              class="absolute -top-7 left-1/2 -translate-x-1/2 mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg whitespace-nowrap">
            See Detail
        </span>
    </a>

</div>

{{-- Modal Konfirmasi Cancel --}}
<x-delete-modal name="confirm-delete-{{ $id }}" :show="false"
    title="Are you sure want to cancel this transaction?">
    <div class="p-3 grid grid-cols-2 justify-between items-center gap-4">
        <button type="button"
                x-on:click="$dispatch('close-modal', 'confirm-delete-{{ $id }}')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-red-normal hover:text-white transition-colors duration-200 bg-transparent border border-red-normal rounded-lg hover:bg-red-normal focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:shadow-outline focus:outline-none">
            No
        </button>
        <button type="button"
                wire:click="cancelTransaction('{{ $id }}')"
                x-on:click="$dispatch('close-modal', 'confirm-delete-{{ $id }}')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-red-normal rounded-lg hover:bg-red-dark focus:ring-2 focus:ring-offset-2 focus:ring-red-dark focus:shadow-outline focus:outline-none">
            Yes
        </button>
    </div>
</x-delete-modal>
