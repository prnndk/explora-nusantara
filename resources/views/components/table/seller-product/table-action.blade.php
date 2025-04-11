<div class="flex flex-row gap-2">
    <a href="{{route('seller.product.detail',$id)}}" class="text-yellow-normal">
        <x-heroicon-m-information-circle class="size-6" />
    </a>
    <a href="{{route('seller.product.detail',$id)}}" class="text-mainGreen">
        <x-heroicon-s-arrow-path class="size-6" />
    </a>
    <button class="text-red-normal hover:text-red-dark" x-on:click="$dispatch('open-modal', 'confirm-delete-{{$id}}')">
        <x-heroicon-s-x-circle class="size-6 text-red-normal hover:text-red-dark" />
    </button>
</div>
<x-delete-modal name="confirm-delete-{{$id}}" :show="false" title="Are you sure want to delete this transaction?">
    <div class="p-3 grid grid-cols-2 justify-between items-center gap-4">
        <button type="button"
                x-on:click="$dispatch('close-modal', 'confirm-delete-{{$id}}')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-red-normal hover:text-white transition-colors duration-200 bg-transparent border border-red-normal rounded-lg hover:bg-red-normal focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:shadow-outline focus:outline-none">
            No
        </button>
        <button type="button" wire:click="deleteProduct('{{$id}}')"
                x-on:click="$dispatch('close-modal', 'confirm-delete-{{$id}}')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-red-normal rounded-lg hover:bg-red-dark focus:ring-2 focus:ring-offset-2 focus:ring-red-dark focus:shadow-outline focus:outline-none">
            Yes
        </button>
    </div>
</x-delete-modal>
