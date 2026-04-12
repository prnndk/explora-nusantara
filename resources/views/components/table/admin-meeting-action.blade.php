<div>
    <div class="flex flex-row justify-center gap-2">
        @if($status === \App\Enums\ProductStatus::PENDING || $status === \App\Enums\ProductStatus::NEW_REQUEST)
        <button x-on:click="$dispatch('open-modal', 'confirm-action-{{ $id }}')" class="text-mainGreen">
            <x-heroicon-s-check-circle class="size-6" />
        </button>
        <button x-on:click="$dispatch('open-modal', 'confirm-delete-{{ $id }}')" class="text-red-normal hover:text-red-dark">
            <x-heroicon-s-x-circle class="size-6" />
        </button>
        @endif

        {{-- Zoom button dengan expired check --}}
        @if($is_expired)
        {{-- Tambahkan klik toast di sini sesuai keinginan kamu tadi --}}
        <button @click="toast('Maaf, link Zoom sudah expired!', {type: 'danger'})"
            class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full">
            Expired
        </button>
        @elseif($status === \App\Enums\ProductStatus::APPROVED && $zoom_meeting_id)
        <a href="{{ $zoom_meeting_id }}" target="_blank" class="text-violet-600">
            <x-heroicon-s-play class="size-6" />
        </a>
        @elseif($status !== \App\Enums\ProductStatus::REJECTED)
        <button @click="toast('Meeting harus di-approve terlebih dahulu!', {type: 'warning'})"
            class="text-gray-400 cursor-not-allowed opacity-50">
            <x-heroicon-s-play class="size-6" />
        </button>
        @endif
    </div>

    {{-- Modal tetap di dalam div utama --}}
    @if($status === \App\Enums\ProductStatus::PENDING || $status === \App\Enums\ProductStatus::NEW_REQUEST)
    <x-warning-modal name="confirm-action-{{$id}}" :show="false" title="Are you sure want to approve this meeting?">
        <div class="p-3 grid grid-cols-2 justify-between items-center gap-4">
            <button type="button" x-on:click="$dispatch('close-modal', 'confirm-action-{{$id}}')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-gray-700 hover:text-black transition-colors duration-200 bg-transparent border border-gray-700 rounded-lg hover:bg-gray-300">
                No
            </button>
            <button type="button" wire:click="approveMeeting('{{$id}}')"
                x-on:click="$dispatch('close-modal', 'confirm-action-{{$id}}')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-mainGreen rounded-lg hover:bg-teal-700">
                Yes
            </button>
        </div>
    </x-warning-modal>

    <x-delete-modal name="confirm-delete-{{$id}}" :show="false" title="Are you sure want to reject this meeting?">
        <div class="p-3 grid grid-cols-2 justify-between items-center gap-4">
            <button type="button" x-on:click="$dispatch('close-modal', 'confirm-delete-{{$id}}')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-red-normal hover:text-white transition-colors duration-200 bg-transparent border border-red-normal rounded-lg hover:bg-red-normal">
                No
            </button>
            <button type="button" wire:click="cancelMeeting('{{$id}}')"
                x-on:click="$dispatch('close-modal', 'confirm-delete-{{$id}}')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-red-normal rounded-lg hover:bg-red-dark">
                Yes
            </button>
        </div>
    </x-delete-modal>
    @endif
</div>