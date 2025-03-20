@props([
    'label' => null,
    'id' => null,
    'name' => null,
    'options' => [],
    'selected' => null,
    'transparent' => false,
])

@php $wireModel = $attributes->get('wire:model');@endphp
<div>
    <div data-model="{{ $wireModel }}"
        class="rounded-md shadow-sm @if ($transparent) text-white @else  @endif ">
        <label for="{{ $id }}"
            class="block text-sm @if ($transparent) text-white @else text-gray-500 @endif tracking-wide mb-2">{{ $label }}</label>
        <select {{ $attributes->whereStartsWith('wire:model') }} id="{{ $id }}" name="{{ $name }}"
            class="bg-gray-50 {{ $transparent ? 'bg-transparent' : 'bg-gray-50' }} border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option>Select</option>
            @foreach ($options as $idoption => $option)
                <option value="{{ $idoption }}" @if ($selected != null and $idoption === $selected) selected @endif>{{ $option }}
                </option>
            @endforeach
        </select>
        @error($wireModel)
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
