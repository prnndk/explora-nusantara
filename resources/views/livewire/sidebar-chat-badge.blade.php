<div>
    <li wire:poll.10s="refreshCount">
        <a href="{{ $route }}"
            wire:navigate
            class="flex items-center px-5 py-3 hover:bg-ecstasy {{ $active ? 'bg-ecstasy' : '' }}"
            :title="! sidebarOpenStatus ? '{{ $title }}' : ''">
            <div class="relative">
                <x-dynamic-component
                    :component="$icon"
                    class="w-6 h-6 text-white" />
                @if($unreadCount > 0)
                <span
                    class="absolute -top-2 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full"
                    x-show="!sidebarOpenStatus">
                    {{ $unreadCount }}
                </span>
                @endif
            </div>

            <span class="ml-3 transition-all flex items-center"
                x-show="sidebarOpenStatus">
                {{ $title }}
                @if($unreadCount > 0)
                <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                    {{ $unreadCount }}
                </span>
                @endif
            </span>
        </a>
    </li>
</div>