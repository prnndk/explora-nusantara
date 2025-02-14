<div class="container mx-6 px-6 my-10 h-full w-full">
    <h2 class="text-white text-3xl font-bold">Welcome Back! <br> Please Login.</h2>
    <div class="flex flex-col md:flex-row items-center justify-between h-full w-full my-8 gap-8">
        <!-- Kiri: Form Register -->
        <div class="w-full max-w-lg">
            <div class="flex flex-col space-y-4">
                <x-input.text placeholder="johndoe" label="Username" :required="true" name="username" transparent="true"
                    wire:model="username" />
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
</div>
