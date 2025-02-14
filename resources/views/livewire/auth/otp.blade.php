<div class="container mx-6 px-6 my-10 flex flex-col md:flex-row items-center justify-between h-full w-full">
    <!-- Kiri: Form Register -->
    <div class="w-full max-w-lg">
        <section id="header" class="my-4 flex flex-col justify-center">
            <h2 class="text-white text-3xl font-bold">Please confirm your account.</h2>
            <ol class="flex items-center w-full text-[11px] font-medium text-white mt-4">
                <li
                    class="flex w-1/2 relative after:content-[''] after:w-full after:h-0.5  after:bg-ecstasy after:inline-block after:absolute  after:top-2 after:left-10">
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
                            class="w-4 h-4 bg-ecstasy border-2 border-transparent rounded-full flex justify-center items-center mx-auto mb-3 text-sm lg:w-4 lg:h-4"></span>
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
        <div class="w-3/4 text-white">
            <h4>We have sent code to <strong> +6212345678987 </strong>. Enter the 5-digit code that we have sent to your
                Whatsapp.</h4>
            <section id="otp" class="my-4 text-neutral-700 text-xl font-bold">
                <form action="#" x-data="otpForm()" method="POST" wire:submit.prevent="submitOtp">
                    <div class="flex justify-between" x-ref="otpInputContainer">
                        <template x-for="(input, index) in length" :key="index">
                            <input type="tel" maxlength="1"
                                class="otpInput border bg-white border-neutral-300 w-16 h-16 text-center rounded-md"
                                x-on:input="handleInput($event, index)" x-on:paste="handlePaste($event)"
                                x-on:keydown.backspace="$event.target.value || handleBackspace($event, index)" />
                        </template>
                    </div>
                    <input type="hidden" name="otp" x-modelable="value" wire:model="otp" />
                    <h3 class="my-5 text-base text-white">Didn't
                        get a code?
                        <a href="#" wire:click="requestOtpCode" class="font-bold tracking-wide">Click to
                            resend.</a>
                    </h3>
                    <x-button type="submit" addClasses="w-full">Verify</x-button>

                </form>
            </section>
            <div class="flex justify-center text-white text-sm my-6">
                <p>
                    I want to cancel account confirmation
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
        function otpForm() {
            return {
                length: 5,
                value: "",

                get inputs() {
                    return this.$refs.otpInputContainer.querySelectorAll('.otpInput');
                },

                handleInput(e, index) {
                    const inputValues = [...this.inputs].map(input => input.value);
                    this.value = inputValues.join('');
                    if (e.target.value) {
                        const nextInput = this.inputs[index + 1];
                        if (nextInput) {
                            nextInput.focus();
                            nextInput.select();
                        }
                    }
                },

                handlePaste(e) {
                    const paste = e.clipboardData.getData('text').slice(0, this.length);
                    paste.split('').forEach((char, i) => {
                        if (this.inputs[i]) {
                            this.inputs[i].value = char;
                        }
                    });
                    this.value = [...this.inputs].map(input => input.value).join('');
                },

                handleBackspace(e, index) {
                    if (index > 0) {
                        this.inputs[index - 1].focus();
                        this.inputs[index - 1].select();
                    }
                },
            };
        }
    </script>
@endpush
