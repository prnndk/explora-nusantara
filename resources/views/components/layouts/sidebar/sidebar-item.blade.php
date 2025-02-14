<li>
    <a href="{{ $route }}" class="flex items-center px-5 py-3 hover:bg-ecstasy {{ $active ? 'bg-ecstasy' : '' }}">
        <x-dynamic-component :component="$icon" class="w-6 h-6 text-white {{ $isSubmenu ? 'ml-6' : '' }}" />
        <span class="ml-3 transition-all" :class="{ 'block': sidebarOpenStatus, 'hidden': !sidebarOpenStatus }">
            {{ $title }}
        </span>
    </a>
</li>
