@props([
    'route' => '#',
    'icon' => 'heroicon-o-chat-bubble-left-right',
    'title' => 'Chat',
    'active' => false,
    'chatCount' => 0,
    'isSubmenu' => false
])

<li>
    <a href="{{ $route }}"
       wire:navigate
       class="flex items-center px-5 py-3 hover:bg-ecstasy {{ $active ? 'bg-ecstasy' : '' }}"
    >
        <div class="relative">
            <x-dynamic-component
                :component="$icon"
                class="w-6 h-6 text-white {{ $isSubmenu ? 'ml-6' : '' }}"
            />
            @if($chatCount > 0)
                <span
                    class="absolute -top-2 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full"
                    x-show="!sidebarOpenStatus"
                >
                    {{ $chatCount }}
                </span>
            @endif
        </div>

        <span class="ml-3 transition-all flex items-center"
              x-show="sidebarOpenStatus"
        >
            {{ $title }}
            @if($chatCount > 0)
                <span
                    class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full"
                >
                    {{ $chatCount }}
                </span>
            @endif
        </span>
    </a>
</li>
