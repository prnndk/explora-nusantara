<div class="container mx-6 px-6 my-10 h-full w-full">
    <h2 class="text-white text-3xl font-bold">Welcome Back! <br> Please Login.</h2>
    @if (session('success_register'))
        <div
            class="relative w-3/4 my-4 rounded-lg border border-transparent bg-green-50 p-4 [&>svg]:absolute [&>svg]:text-foreground [&>svg]:left-4 [&>svg]:top-4 [&>svg+div]:translate-y-[-3px] [&:has(svg)]:pl-11 text-green-600">
            <svg class="w-5 h-5 -translate-y-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h5 class="mb-1 font-medium leading-none tracking-tight">{{ session('success_register') }}</h5>
            <div class="text-sm opacity-80">Terimakasih telah mendaftar ke explora nusantara. Silahkan masuk menggunakan
                kredensial yang telah didaftarkan</div>
        </div>
    @endif
    <div class="flex flex-col md:flex-row items-center justify-between h-full w-full my-8 gap-8">
        <!-- Kiri: Form Register -->
        <div class="w-full max-w-lg">
            <div class="flex flex-col space-y-4">
                <x-input.text placeholder="johndoe" label="Username" :required="true" name="username"
                    transparent="true" wire:model="username" />
                <x-input.password :transparent="true" label="Password" :required="true" name="password"
                    placeholder="********" wire:model="password" />
                <x-button type="primary" addClasses="w-full" wire:click="loginProcess">
                    Login
                </x-button>
                <div class="flex justify-center text-white text-sm">
                    <p>
                        Don't have an account?? <a href="{{ route('register') }}" class="font-bold tracking-wide"
                            wire:navigate>Register</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Kanan: Informasi -->
        <div class="w-full max-w-md text-white md:text-left text-center hidden md:block">
            <h1 class="text-4xl font-bold leading-tight">
                Unlocking Global <br> Potential for <br> Indonesia's SMEs
            </h1>
        </div>
    </div>
    @push('scripts')
        <script>
            //on enter key press
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    @this.loginProcess();
                }
            });
        </script>
    @endpush
</div>
