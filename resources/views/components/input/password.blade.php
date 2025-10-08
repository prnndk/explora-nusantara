@props(['placeholder' => '', 'name' => '', 'label' => '', 'required' => false, 'transparent' => false])

@php
    $normal_style =
        'border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50';
    $transparent_style =
        'bg-transparent border-neutral-300 ring-offset-background text-white placeholder:text-white focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mainGreen disabled:cursor-not-allowed disabled:opacity-50';
    $error_style = 'border-red-500 focus:border-red-500 focus:ring-red-500';
@endphp

<div class="w-full max-w-lg relative">
    <label for="{{ $name }}"
        class="block text-sm {{ $transparent ? 'text-white' : 'text-neutral-800' }} tracking-wide mb-2">{{ $label }}
        {!! $required ? '<span class="text-red-500">*</span>' : '' !!} </label>
    <input type="password" placeholder="{{ $placeholder }}" name="{{ $name }}" id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' =>
                'flex w-full h-10 px-3 py-2 text-sm border rounded-md pr-10 ' .
                ($transparent ? $transparent_style : $normal_style) .
                ($errors->has($name) ? ' ' . $error_style : ''),
        ]) }} />
    <button type="button" onclick="togglePassword('{{ $name }}')"
        class="absolute right-3 top-[38px] text-gray-400 hover:text-gray-600">
        <svg id="eye-open-{{ $name }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        <svg id="eye-closed-{{ $name }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.978 9.978 0 012.101-3.364M6.223 6.223A9.956 9.956 0 0112 5c4.478 0 8.269 2.943 9.543 7a9.969 9.969 0 01-4.132 4.623M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
        </svg>
    </button>
    @error($name)
        <p class="text-neutral-300 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

@once
    @push('scripts')
        <script>
            function togglePassword(fieldId) {
                const input = document.getElementById(fieldId);
                const eyeOpen = document.getElementById("eye-open-" + fieldId);
                const eyeClosed = document.getElementById("eye-closed-" + fieldId);

                if (input.type === "password") {
                    input.type = "text";
                    eyeOpen.classList.add("hidden");
                    eyeClosed.classList.remove("hidden");
                } else {
                    input.type = "password";
                    eyeClosed.classList.add("hidden");
                    eyeOpen.classList.remove("hidden");
                }
            }
        </script>
    @endpush
@endonce
