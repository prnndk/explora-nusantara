@props(['name', 'show' => false, 'maxWidth' => 'md', 'title' => ''])

@php
    $maxWidthClass = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth] ?? 'sm:max-w-md';
@endphp

<div x-data="{ show: @js($show) }"
     x-init="$watch('show', value => document.body.classList.toggle('overflow-hidden', value))"
     x-on:open-modal.window="$event.detail === '{{ $name }}' ? show = true : null"
     x-on:close-modal.window="$event.detail === '{{ $name }}' ? show = false : null"
     x-on:keydown.escape.window="show = false"
     x-show="show"
     class="relative z-50">

    <template x-teleport="body">
        <div x-show="show" class="fixed inset-0 z-[99] flex items-center justify-center w-screen h-screen" x-cloak>
            <!-- Overlay -->
            <div x-show="show" x-transition.opacity class="absolute inset-0 bg-black bg-opacity-40"
                 @click="show = false"></div>

            <!-- Modal Container -->
            <div x-show="show" x-trap.noscroll="show" x-transition
                 class="relative bg-white px-6 sm:py-4 rounded-xl shadow-xl w-full {{ $maxWidthClass }}">

                <div class="absolute top-4 right-4">
                    <button @click="show = false" class="text-gray-500 hover:text-gray-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="flex flex-col items-center text-center space-y-4">
                    <x-heroicon-c-x-circle class="w-20 h-20 text-red-normal"/>
                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ $title }}
                    </h3>
                </div>

                <div class="mt-4 text-center text-sm text-gray-700">
                    {{ $slot }}
                </div>

            </div>
        </div>
    </template>
</div>
