@props(['name', 'show' => false, 'maxWidth' => 'lg', 'title' => 'Modal Title'])

@php
    $maxWidthClass =
        [
            'sm' => 'sm:max-w-sm',
            'md' => 'sm:max-w-md',
            'lg' => 'sm:max-w-lg',
            'xl' => 'sm:max-w-xl',
            '2xl' => 'sm:max-w-2xl',
        ][$maxWidth] ?? 'sm:max-w-lg';
@endphp

<div x-data="{ show: @js($show) }" x-init="$watch('show', value => {
    if (value) document.body.classList.add('overflow-hidden');
    else document.body.classList.remove('overflow-hidden');
})"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:keydown.escape.window="show = false" x-show="show" class="relative z-50 w-auto h-auto">

    <template x-teleport="body">
        <div x-show="show" class="fixed inset-0 z-[99] flex items-center justify-center w-screen h-screen" x-cloak>
            <!-- Background Overlay -->
            <div x-show="show" x-transition.opacity class="absolute inset-0 bg-black bg-opacity-40"
                @click="show = false"></div>

            <!-- Modal Container -->
            <div x-show="show" x-trap.noscroll="show" x-transition
                class="relative w-full bg-white px-7 py-6 rounded-lg shadow-xl sm:w-full {{ $maxWidthClass }}">
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-2">
                    <div class="flex flex-row gap-2 items-center">
                        <x-heroicon-o-exclamation-circle class="size-8 text-yellow-normal" />
                        <h3 class="text-lg font-semibold">{{ $title }}</h3>
                    </div>
                    <button @click="show = false" class="text-gray-600 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="relative w-auto">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </template>
</div>
