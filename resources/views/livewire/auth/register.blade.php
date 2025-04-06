<div class="container mx-6 px-6 my-10 flex flex-col md:flex-row items-center justify-between h-full w-full">
    <!-- Kiri: Form Register -->
    <div class="w-full max-w-lg">
        <section id="header" class="my-4">
            <h2 class="text-white text-3xl font-bold">Welcome! <br> Create new account.</h2>
            <ol class="flex items-center w-full text-[11px] font-medium text-white mt-4">
                <li
                    class="flex w-1/2 relative after:content-[''] after:w-full after:h-0.5  after:bg-gray-200 after:inline-block after:absolute  after:top-2 after:left-10">
                    <div class="block z-10">
                        <span
                            class="w-4 h-4 bg-ecstasy border-2 border-transparent rounded-full flex justify-center items-center mx-auto mb-3 text-sm text-white lg:w-4 lg:h-4"></span>
                        Create Account
                    </div>
                </li>
                <li
                    class="flex w-1/2 relative after:content-[''] after:w-full after:h-0.5  after:bg-gray-200 after:inline-block after:absolute after:top-2 after:left-10">
                    <div class="block z-10">
                        <span
                            class="w-4 h-4 bg-gray-50 border-2 border-gray-200 rounded-full flex justify-center items-center mx-auto mb-3 text-sm lg:w-4 lg:h-4"></span>
                        Confirm Account
                    </div>
                </li>
                <li class="flex w-full relative">
                    <div class="block z-10">
                        <span
                            class="w-4 h-4 bg-gray-50 border-2 border-gray-200 rounded-full flex justify-center items-center mx-auto mb-3 text-sm lg:w-4 lg:h-4"></span>
                        Register Details
                    </div>
                </li>
            </ol>
        </section>
        <form wire:submit.prevent="firstStep">
            <div class="flex flex-col space-y-4">
                <x-input.text placeholder="johndoe" label="Username" :required="true" name="username"
                    transparent="true" wire:model="username" />
                <x-input.text placeholder="example@mail.com" label="Email Address" :required="true" name="email"
                    type="email" transparent="true" wire:model="email" />
                <x-input.password :transparent="true" label="Password" :required="true" name="password"
                    placeholder="********" wire:model="password" />
                <x-input.password :transparent="true" label="Confirm Password" :required=true name="password_confirmation"
                    placeholder="********" wire:model="password_confirmation" />
                {{-- <x-input.tel :transparent="true" label="Phone Number" :required="true" name="phone_number"
                wire:model="phone_number" /> --}}
                <div class="w-3/4 max-w-lg">
                    <label for="" class="block text-sm text-white tracking-wide mb-2">Account Type</label>
                    <div class="flex justify-between">
                        <div class="flex items-center me-4">
                            <input id="inline-radio" type="radio" value="seller" name="account_type"
                                wire:model="account_type"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-neutral-300 focus:ring-blue-500 focus:ring-2">
                            <label for="inline-radio" class="ms-2 text-sm font-medium text-white">Seller</label>
                        </div>
                        <div class="flex items-center me-4">
                            <input id="inline-2-radio" type="radio" value="buyer" name="account_type"
                                wire:model="account_type"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-neutral-300 focus:ring-blue-500 focus:ring-2">
                            <label for="inline-2-radio" class="ms-2 text-sm font-medium text-white">Buyer</label>
                        </div>
                    </div>
                    @error('account_type')
                        <span class="text-neutral-300 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <x-button type="primary" addClasses="w-full">Next</x-button>
                <div class="flex justify-center text-white text-sm">
                    <p>
                        Have an account?? <a href="/login" class="font-bold tracking-wide" wire:navigate>Login</a>
                    </p>
                </div>
            </div>
        </form>

    </div>

    <!-- Kanan: Informasi -->
    <div class="w-full max-w-md text-white md:text-left text-center hidden md:block">
        <h1 class="text-4xl font-bold leading-tight">
            Unlocking Global <br> Potential for <br> Indonesia's SMEs
        </h1>
    </div>
</div>
