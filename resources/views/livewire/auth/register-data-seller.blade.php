<div class="container mx-6 px-6 my-10 h-full w-full">
    <h2 class="text-white text-3xl font-bold">Last Step! <br> Complete the seller data.</h2>
    <div class="flex flex-col md:flex-row items-center justify-between h-full w-full">
        <div class="w-full mt-6">
            <form wire:submit.prevent=submitData enctype="multipart/form-data">
                <section id="header" class="my-4 grid grid-cols-1 md:grid-cols-2 gap-8 w-full mb-8">
                    <!-- Progress Steps (Centered) -->
                    <div class="flex flex-col justify-center w-full">
                        <ol class="flex items-center justify-between w-full text-xs font-medium text-white mt-4">
                            <li
                                class="flex flex-1 relative after:content-[''] after:w-full after:h-0.5 after:bg-ecstasy after:inline-block after:absolute after:top-2 after:left-10">
                                <div class="block z-10 text-center">
                                    <span
                                        class="w-4 h-4 bg-ecstasy border-2 border-transparent rounded-full flex justify-center items-center mx-auto mb-3 text-sm text-white lg:w-4 lg:h-4"></span>
                                    Create Account
                                </div>
                            </li>
                            <li
                                class="flex flex-1 relative after:content-[''] after:w-full after:h-0.5 after:bg-ecstasy after:inline-block after:absolute after:top-2 after:left-10">
                                <div class="block z-10 text-center">
                                    <span
                                        class="w-4 h-4 bg-ecstasy border-2 border-transparent rounded-full flex justify-center items-center mx-auto mb-3 text-sm lg:w-4 lg:h-4"></span>
                                    Confirm Account
                                </div>
                            </li>
                            <li class="flex flex-1">
                                <div class="block z-10 text-center">
                                    <span
                                        class="w-4 h-4 bg-ecstasy border-2 border-transparent rounded-full flex justify-center items-center mx-auto mb-3 text-sm lg:w-4 lg:h-4"></span>
                                    Register Details
                                </div>
                            </li>
                        </ol>
                    </div>

                    <!-- Submit Button (Right-Aligned on Desktop) -->
                    <div class="flex justify-center items-center md:justify-end">
                        <x-button type="primary" class="w-52">Submit</x-button>
                    </div>
                </section>
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-1/2 space-y-4">
                        <x-input.text placeholder="johndoe" label="Full Name" required="true" name="fullname"
                            transparent="true" wire:model="name" />
                        <x-input.text placeholder="xxxxxxxxxxxxxxxx" label="NIK" required="true" name="nik"
                            transparent="true" maxlength="16" minlength="16" inputmode="numeric" pattern="[0-9\s]{16}"
                            wire:model="nik" />
                        <x-input.text placeholder="example@mail.com" label="Seller Email" required="true"
                            name="seller_email" transparent="true" type="email" wire:model="email" />
                        <x-input.tel placeholder="08xxxxxxxxxx" label="Phone Number" required="true" name="phone_number"
                            transparent="true" wire:model="phone_number" id="phone_number" />
                        <x-input.text placeholder="Jl. Surabaya" label="Address" required="true" name="address"
                            transparent="true" wire:model="address" />
                        <livewire:input.file-upload name="ktp" label="Upload File Scan KTP" wire:model="ktp_file_id"
                            key="ktp" user_id="{{ $user_id }}" :required="true" />
                        <livewire:input.file-upload name="ktp" label="Upload File Pas Foto"
                            wire:model="photo_file_id" key="photo" user_id="{{ $user_id }}" :required="true" />
                    </div>
                    <div class="w-full md:w-1/2 space-y-4 ">
                        <x-input.text placeholder="PT xxyyzz" label="Company Name" required="true" name="company_name"
                            transparent="true" wire:model="company_name" />
                        <x-input.text placeholder="xxxxxxxxxxxxxxxx" label="NPWP" required="true" name="npwp"
                            transparent="true" maxlength="16" minlength="16" inputmode="numeric" pattern="[0-9\s]{16}"
                            wire:model="npwp" />
                        <x-input.text placeholder="xxxxxxxxxxxxxxxx" label="NIB (Nomor Induk Berusaha)" required="true"
                            name="nib" transparent="true" maxlength="13" minlength="13" inputmode="numeric"
                            pattern="[0-9\s]{13}" wire:model="nib" />
                        <x-input.text placeholder="Jl. Surabaya" label="Company Address" required="true"
                            name="company_address" transparent="true" wire:model="company_address" />
                        <x-input.tel placeholder="08xxxxxxxxxx" label="Company Phone Number" required="true"
                            id="company_phone_number" name="company_phone_number" transparent="true"
                            wire:model="company_phone_number" />
                        {{-- <x-input.select :transparent="true" label="Select Bank" /> --}}
                        <x-input.text placeholder="Nama Bank" label="Bank" required="true" name="bank"
                            transparent="true" wire:model="bank_name" />
                        <x-input.text placeholder="xxxxxxxxxxxx" label="Bank Account Number" required="true"
                            name="bank_account_number" transparent="true" wire:model="bank_account_number" />
                        <livewire:input.file-upload name="surat_legalitas_usaha"
                            label="Upload File (Scan Surat Rekomendasi Dinas Provinsi)"
                            wire:model="recommendation_letter_file_id" key="recommendation"
                            user_id="{{ $user_id }}" :required="true" />
                    </div>
                </div>
            </form>
        </div>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('formValidation', () => ({
                    init() {
                        this.$watch('nik', value => {
                            this.nik = value.replace(/\D/g, '');
                        });
                        this.$watch('bank_account_number', value => {
                            this.bank_account_number = value.replace(/\D/g, '');
                        });
                    },
                    nik: '',
                    bank_account_number: ''
                }));
            });
        </script>
    @endpush
</div>
