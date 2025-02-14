@props(['placeholder' => '', 'name' => '', 'label' => '', 'required' => false, 'transparent' => false])

@php
    $normal_style =
        'border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50';
    $transparent_style =
        'bg-transparent border-neutral-300 ring-offset-background text-white placeholder:text-white focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mainGreen disabled:cursor-not-allowed disabled:opacity-50';
    $error_style = 'border-red-500 focus:border-red-500 focus:ring-red-500';
@endphp

<div class="w-full max-w-lg">
    <label for="{{ $name }}" class="block text-sm text-white tracking-wide mb-2">{{ $label }}
        {!! $required ? '<span class="text-red-500">*</span>' : '' !!} </label>
    <input type="password" placeholder="{{ $placeholder }}" name="{{ $name }}" id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'flex w-full h-10 px-3 py-2 text-sm border rounded-md ' . ($transparent ? $transparent_style : $normal_style) . ($errors->has($name) ? ' ' . $error_style : '')]) }} />
    @error($name)
        <p class="text-neutral-300 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
