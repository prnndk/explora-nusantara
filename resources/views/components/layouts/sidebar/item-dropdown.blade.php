@props(['icon', 'title'])
<li x-data="{ dropdownOpen: false }" @click.away="dropdownOpen = false">
    <button @click="dropdownOpen = !dropdownOpen; sidebarOpenStatus=true"
        class="flex items-center w-full px-5 py-3 hover:bg-ecstasy">
        <x-dynamic-component :component="$icon" class="w-6 h-6 text-white" />
        <span class="flex-1 ml-3 text-left" :class="{ 'block': sidebarOpenStatus, 'hidden': !sidebarOpenStatus }">
            {{ $title }}
        </span>
        <x-heroicon-s-chevron-down class="w-4 h-4 transition-transform" ::class="{ 'block': sidebarOpenStatus, 'hidden': !sidebarOpenStatus, 'rotate-180': dropdownOpen }" />
    </button>
    <ul x-show="dropdownOpen" x-transition class="space-y-1">
        {{ $slot }}
    </ul>
</li>
