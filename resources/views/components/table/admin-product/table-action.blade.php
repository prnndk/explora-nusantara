<div class="flex flex-row gap-3 items-center">

    {{-- Approve --}}
    <button class="relative flex items-center justify-center p-2 rounded-lg text-mainGreen transition hover:bg-gray-100"
            x-data="{ showTooltip: false }"
            @mouseenter="showTooltip = true"
            @mouseleave="showTooltip = false"
            x-on:click="$dispatch('open-modal', 'confirm-approval-{{ $id }}')">
        <x-heroicon-s-check-circle class="w-6 h-6" />
        <span x-show="showTooltip"
              x-transition
              class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg whitespace-nowrap">
            Approve Product
        </span>
    </button>

    {{-- Reject --}}
    <button class="relative flex items-center justify-center p-2 rounded-lg text-red-normal transition hover:bg-gray-100"
            x-data="{ showTooltip: false }"
            @mouseenter="showTooltip = true"
            @mouseleave="showTooltip = false"
            x-on:click="$dispatch('open-modal', 'confirm-rejection-{{ $id }}')">
        <x-heroicon-s-x-circle class="w-6 h-6" />
        <span x-show="showTooltip"
              x-transition
              class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg whitespace-nowrap">
            Reject Product
        </span>
    </button>

    {{-- Detail --}}
    <a href="{{ route('admin.product.detail', $id) }}" 
       wire:navigate
       class="relative flex items-center justify-center p-2 rounded-lg text-yellow-normal transition hover:bg-gray-100"
       x-data="{ showTooltip: false }"
       @mouseenter="showTooltip = true"
       @mouseleave="showTooltip = false">
        <x-heroicon-s-information-circle class="w-6 h-6" />
        <span x-show="showTooltip"
              x-transition
              class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg whitespace-nowrap">
            Detail Product
        </span>
    </a>

</div>

{{-- Modal Konfirmasi Approve --}}
<x-warning-modal name="confirm-approval-{{ $id }}" :show="false"
    title="Are you sure want to approve this product?">
    <div class="p-3 grid grid-cols-2 justify-between items-center gap-4">
        <button type="button"
                x-on:click="$dispatch('close-modal', 'confirm-approval-{{ $id }}')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-gray-700 hover:text-black transition-colors duration-200 bg-transparent border border-gray-700 rounded-lg hover:bg-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-700 focus:outline-none">
            No
        </button>
        <button type="button"
                wire:click="acceptProduct('{{ $id }}')"
                x-on:click="$dispatch('close-modal', 'confirm-approval-{{ $id }}')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-mainGreen rounded-lg hover:bg-teal-700 focus:ring-2 focus:ring-offset-2 focus:ring-teal-700 focus:outline-none">
            Yes
        </button>
    </div>
</x-warning-modal>

{{-- Modal Konfirmasi Reject --}}
<x-delete-modal name="confirm-rejection-{{ $id }}" :show="false"
    title="Are you sure want to reject this product?">
    <div class="p-3 grid grid-cols-2 justify-between items-center gap-4">
        <button type="button"
                x-on:click="$dispatch('close-modal', 'confirm-rejection-{{ $id }}')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-red-normal hover:text-white transition-colors duration-200 bg-transparent border border-red-normal rounded-lg hover:bg-red-normal focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:outline-none">
            No
        </button>
        <button type="button"
                wire:click="rejectProduct('{{ $id }}')"
                x-on:click="$dispatch('close-modal', 'confirm-rejection-{{ $id }}')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-red-normal rounded-lg hover:bg-red-dark focus:ring-2 focus:ring-offset-2 focus:ring-red-dark focus:outline-none">
            Yes
        </button>
    </div>
</x-delete-modal>
