@props(['heading', 'description', 'color' => 'primary', 'icon', 'link' => '#'])



@php
    $mainColor = 'bg-mainGreen';
    $secondaryColor = 'bg-ecstasy';

    if ($color === 'secondary') {
        $color = $secondaryColor;
    } else {
        $color = $mainColor;
    }
@endphp

<div class="flex flex-row items-center gap-4">
    <div class="p-4 rounded-full {{ $color }} text-white">
        <x-dynamic-component component="{{ $icon }}" class="w-6 h-6 transform" />
    </div>
    <div>
        <h4 class="font-bold text-lg inline">{{ $heading }}</h4>
        <p class="text-sm">{{ $description }}</p>
    </div>
    <div class="ml-auto">
        <a href="{{ $link }}" wire:navigate>
            <span class="rounded-full px-4 py-1 text-white text-xs {{ $color }}">
                See
            </span>
        </a>
    </div>
</div>
