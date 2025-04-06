@props(['placeholder' => '', 'name' => '', 'label' => '', 'required' => false, 'transparent' => false])

@php
    $normal_style =
        'border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50';
    $transparent_style =
        'bg-transparent border-neutral-300 ring-offset-background text-white placeholder:text-white focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mainGreen disabled:cursor-not-allowed disabled:opacity-50';
    $error_style = 'border-red-500 focus:border-red-500 focus:ring-red-500';
@endphp

<div>
    <label for="{{ $name }}"
        class="block text-sm @if ($transparent) text-white @else text-gray-500 @endif tracking-wide mb-2">{{ $label }}
        {!! $required ? '<span class="text-red-500">*</span>' : '' !!} </label>
    <div class="relative">
        <div
            class="absolute inset-y-0 left-0 flex items-center px-3 {{ $transparent ? 'text-white' : 'text-gray-800' }} pointer-events-none text-[0.875rem]">
            +62
        </div>
        <input type="text" name="phone" {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'block w-full ps-12 p-2.5 text-sm border rounded-md ' . ($transparent ? $transparent_style : $normal_style) . ($errors->has($name) ? ' ' . $error_style : '')]) }}
            pattern="[0-9]{10,13}" placeholder="8123456789" inputmode="numeric" maxlength="15"
            oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
    </div>
    @error($name)
        <p class="text-neutral-300 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
