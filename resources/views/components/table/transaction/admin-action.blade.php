<div class="flex flex-row gap-2 items-center">
    {{-- Approve Button --}}
    <div class="relative group flex items-center">
        <button 
            x-on:click="$dispatch('open-modal', 'confirm-action-{{ $id }}')" 
            class="flex items-center justify-center text-mainGreen hover:text-teal-700 transition-colors duration-200"
        >
            <x-heroicon-s-check-circle class="size-6"/>
        </button>
        <div 
            class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition text-xs bg-gray-800 text-white px-2 py-1 rounded-md pointer-events-none whitespace-nowrap">
            Approve
        </div>
    </div>

    {{-- Reject Button --}}
    <div class="relative group flex items-center">
        <button 
            x-on:click="$dispatch('open-modal', 'confirm-delete-{{ $id }}')" 
            class="flex items-center justify-center text-red-normal hover:text-red-dark transition-colors duration-200"
        >
            <x-heroicon-s-x-circle class="size-6"/>
        </button>
        <div 
            class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition text-xs bg-gray-800 text-white px-2 py-1 rounded-md pointer-events-none whitespace-nowrap">
            Reject
        </div>
    </div>

    {{-- See Detail Button --}}
    <div class="relative group flex items-center">
        <a href="{{ route('admin.transaction.detail', $id) }}" wire:navigate 
           class="flex items-center justify-center text-amber-600 hover:text-amber-700 transition-colors duration-200">
            <x-heroicon-s-information-circle class="size-6"/>
        </a>
        <div 
            class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition text-xs bg-gray-800 text-white px-2 py-1 rounded-md pointer-events-none whitespace-nowrap">
            See Detail
        </div>
    </div>
</div>
