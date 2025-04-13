<div class="flex flex-row gap-2">
    <button x-on:click="$dispatch('open-modal', 'confirm-action-{{ $id }}')" class="text-mainGreen">
        <x-heroicon-s-check-circle class="size-6" />
    </button>
    <button x-on:click="$dispatch('open-modal', 'confirm-delete-{{ $id }}')"
        class="text-red-normal hover:text-red-dark">
        <x-heroicon-s-x-circle class="size-6 text-red-normal hover:text-red-dark" />
    </button>
    <a href="{{route('admin.contract.detail', $id)}}" wire:navigate class="text-amber-600">
        <x-heroicon-m-information-circle class="size-6" />
    </a>
</div>
<x-warning-modal name="confirm-action-{{$id}}" :show="false" title="Are you sure want to approve this contract?">
    <div class="p-3 grid grid-cols-2 justify-between items-center gap-4">
        <button type="button" x-on:click="$dispatch('close-modal', 'confirm-action-{{$id}}')"
            class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-gray-700 hover:text-black transition-colors duration-200 bg-transparent border border-gray-700 rounded-lg hover:bg-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-700 focus:shadow-outline focus:outline-none">
            No
        </button>
        <button type="button" wire:click="approveContract('{{$id}}')"
            x-on:click="$dispatch('close-modal', 'confirm-action-{{$id}}')"
            class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-mainGreen rounded-lg hover:bg-teal-700 focus:ring-2 focus:ring-offset-2 focus:ring-teal-700 focus:shadow-outline focus:outline-none">
            Yes
        </button>
    </div>
</x-warning-modal>
<x-delete-modal name="confirm-delete-{{$id}}" :show="false" title="Are you sure want to reject this contract?">
    <div class="p-3 grid grid-cols-2 justify-between items-center gap-4">
        <button type="button" x-on:click="$dispatch('close-modal', 'confirm-delete-{{$id}}')"
            class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-red-normal hover:text-white transition-colors duration-200 bg-transparent border border-red-normal rounded-lg hover:bg-red-normal focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:shadow-outline focus:outline-none">
            No
        </button>
        <button type="button" wire:click="cancelContract('{{$id}}')"
            x-on:click="$dispatch('close-modal', 'confirm-delete-{{$id}}')"
            class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-red-normal rounded-lg hover:bg-red-dark focus:ring-2 focus:ring-offset-2 focus:ring-red-dark focus:shadow-outline focus:outline-none">
            Yes
        </button>
    </div>
</x-delete-modal>