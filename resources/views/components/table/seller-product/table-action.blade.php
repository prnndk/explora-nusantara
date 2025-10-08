<div class="flex flex-row gap-3 items-center">

    {{-- Detail Produk --}}
    <a href="{{ route('seller.product.detail', $id) }}"
       class="relative flex items-center justify-center p-2 rounded-lg text-yellow-normal transition hover:bg-gray-100"
       x-data="{ showTooltip: false }"
       @mouseenter="showTooltip = true"
       @mouseleave="showTooltip = false">
        <x-heroicon-o-information-circle class="w-6 h-6" />
        <span x-show="showTooltip"
              x-transition
              class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg whitespace-nowrap">
            Detail Product
        </span>
    </a>

    {{-- Edit Produk --}}
    <a href="{{ route('seller.product.detail', $id) }}"
       class="relative flex items-center justify-center p-2 rounded-lg text-mainGreen transition hover:bg-gray-100"
       x-data="{ showTooltip: false }"
       @mouseenter="showTooltip = true"
       @mouseleave="showTooltip = false">
        <x-heroicon-o-pencil-square class="w-6 h-6" />
        <span x-show="showTooltip"
              x-transition
              class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg whitespace-nowrap">
            Edit Product
        </span>
    </a>

    {{-- Hapus Produk --}}
    <button class="relative flex items-center justify-center p-2 rounded-lg text-red-normal transition hover:bg-gray-100"
            x-data="{ showTooltip: false }"
            @mouseenter="showTooltip = true"
            @mouseleave="showTooltip = false"
            x-on:click="$dispatch('open-modal', 'confirm-delete-{{ $id }}')">
        <x-heroicon-o-trash class="w-6 h-6" />
        <span x-show="showTooltip"
              x-transition
              class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg whitespace-nowrap">
            Delete Product
        </span>
    </button>

</div>

{{-- Modal Konfirmasi Hapus --}}
<x-delete-modal name="confirm-delete-{{ $id }}" :show="false" title="Are you sure want to delete this product?">
    <div class="p-3 grid grid-cols-2 justify-between items-center gap-4">
        <button type="button"
                x-on:click="$dispatch('close-modal', 'confirm-delete-{{ $id }}')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-red-normal hover:text-white transition-colors duration-200 bg-transparent border border-red-normal rounded-lg hover:bg-red-normal focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:outline-none">
            No
        </button>
        <button type="button"
                wire:click="deleteProduct('{{ $id }}')"
                x-on:click="$dispatch('close-modal', 'confirm-delete-{{ $id }}')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-red-normal rounded-lg hover:bg-red-dark focus:ring-2 focus:ring-offset-2 focus:ring-red-dark focus:outline-none">
            Yes
        </button>
    </div>
</x-delete-modal>
