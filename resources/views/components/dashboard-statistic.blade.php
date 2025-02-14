@php
    $mainColor = 'bg-mainGreen';
    $secondaryColor = 'bg-ecstasy';

    if ($color === 'main') {
        $color = $mainColor;
    } elseif ($color === 'secondary') {
        $color = $secondaryColor;
    } else {
        $color = $mainColor;
    }
@endphp

<div class="flex flex-row items-center gap-4">
    <div class="p-4 rounded-full {{ $color }} text-white">
        <x-dynamic-component :component="$icon" class="w-12 h-12 transform" ::class="{ 'w-8 h-8': sidebarOpenStatus, 'w-12 h-12': !sidebarOpenStatus }" />
    </div>
    <div>
        <h4 class="font-bold text-3xl inline">{{ $heading }}</h4>@if ($smallNumber)<span class="text-sm inline">/{{ $smallNumber }}</span>@endif
        <p>{{ $title }}</p>
    </div>
</div>
