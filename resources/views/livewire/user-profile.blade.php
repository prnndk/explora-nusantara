<div>
    <h1 class="text-4xl font-bold">
        @if ($user->isSeller())
            Seller Profile
        @elseif ($user->isBuyer())
            Buyer Profile
        @elseif ($user->isAdmin())
            Admin Profile
        @else
            User Profile
        @endif
    </h1>
    <h6>Easily manage your account information and preferences in one intuitive and personalized place.</h6>

    <div class="grid md:grid-cols-2 gap-4 mt-8 min-h-full">
        <div class="flex flex-col items-center gap-4">
            @if ($this->user->isAdmin())
                <img src="https://ui-avatars.com/api/?name={{ $user->username }}" alt="User"
                    class="w-48 h-48 rounded-full transition-all" />
            @else
                <img src="/view-file/{{ $user->buyer->photoFile->id ?? $user->seller->photoFile->id }}" alt="User"
                    class="w-48 h-48 rounded-full transition-all" />
            @endif
            <span class="font-semibold text-lg flex items-center gap-2" type="primary">{{ $user->username }}
                @unless ($user->isAdmin())
                    <x-heroicon-c-pencil-square class="w-5 h-5 cursor-pointer"
                        x-on:click="$dispatch('open-modal', 'update-profile')" />
                @endunless
            </span>
        </div>

        @if ($user->role === \App\Enums\UserRole::ADMIN)
            <div class="space-y-4">
                <div class="w-full">
                    <x-input.text label="Email" name="email" value="{{ $user->email }}" :required="true"
                        class="flex-grow" disabled read-only />
                </div>
                <div class="flex flex-row gap-2 items-end w-full">
                    <div class="w-5/6">
                        <x-input.text label="Password" name="password" value="********" disabled read-only
                            :required="true" class="flex-grow" />
                    </div>
                    <div class="w-1/6">
                        <x-button type="outline-neutral" wire:click.prevent="changePassword"
                            addClasses="px-4 h-10 whitespace-nowrap w-full">Change
                        </x-button>
                    </div>
                </div>
            </div>
        @else
            <div class="flex flex-col gap-4" x-data="{ tab: 'detail' }">
                <div class="flex gap-10">
                    <button @click="tab = 'detail'" class="text-lg"
                        :class="{ 'font-semibold': tab === 'detail' }">Detail
                    </button>
                    <button @click="tab = 'account'" class="text-lg"
                        :class="{ 'font-semibold': tab === 'account' }">Account
                    </button>
                    <button @click="tab = 'company'" class="text-lg"
                        :class="{ 'font-semibold': tab === 'company' }">Company
                    </button>
                </div>

                <div class="grid grid-cols-1 gap-4" x-show="tab === 'detail'">
                    <x-input.text label="Your Name" name="name"
                        value="{{ $user->buyer->name ?? $user->seller->name }}" :required="true" wire:model="name" />
                    <x-input.text label="NIK" name="nik" value="{{ $user->buyer->nik ?? $user->seller->nik }}"
                        :required="true" wire:model="nik" />
                    <x-input.tel label="Phone Number" name="phone_number"
                        value="{{ $user->buyer->phone_number ?? $user->seller->phone_number }}" :required="true"
                        wire:model="phone_number" />
                    <x-input.text label="Address" name="address"
                        value="{{ $user->buyer->address ?? $user->seller->address }}" :required="true"
                        wire:model="address" />
                    <div>
                        <span class="block mb-2 text-sm tracking-wide text-gray-500">Scan KTP</span>
                        <div x-data="{ dropdownOpen: false }" class="relative">

                            <button @click.prevent="dropdownOpen = true"
                                class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">
                                <x-heroicon-o-document class="w-5 h-5 mr-3" />
                                {{ str_replace('uploads/', '', $user->buyer->ktpFile->file_path ?? $user->seller->ktpFile->file_path) }}
                                <x-heroicon-c-ellipsis-vertical class="w-5 h-5 ml-3" />
                            </button>

                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                                x-transition:enter="ease-out duration-200" x-transition:enter-start="-translate-y-2"
                                x-transition:enter-end="translate-y-0" class="absolute top-full left-0 mt-2 z-50 w-56"
                                x-cloak>
                                <div
                                    class="p-1 mt-1 text-sm bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                                    <a href="/view-file/{{ $user->buyer->ktpFile->id ?? $user->seller->ktpFile->id }}"
                                        @click="dropdownOpen = false"
                                        class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                        <span>Open File</span>
                                    </a>
                                    <button @click="dropdownOpen = false; $dispatch('open-modal', 'update-ktp')"
                                        class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                        <span>Edit File</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4" x-show="tab === 'account'">
                    {{--                    <div class="flex flex-row gap-2 items-end w-full"> --}}
                    {{--                        <div class="w-5/6"> --}}
                    <x-input.text label="Email" name="email" value="{{ $user->email }}" :required="true"
                        class="flex-grow" disabled read-only />
                    {{--                        </div> --}}
                    {{--                        <div class="w-1/6"> --}}
                    {{--                            <x-button type="outline-ecstasy" --}}
                    {{--                                      addClasses="px-4 h-10 whitespace-nowrap w-full">Verify --}}
                    {{--                            </x-button> --}}
                    {{--                        </div> --}}
                    {{--                    </div> --}}
                    <div class="flex flex-row gap-2 items-end w-full">
                        <div class="w-5/6">
                            <x-input.text label="Password" name="password" value="********" disabled read-only
                                :required="true" class="flex-grow" />
                        </div>
                        <div class="w-1/6">
                            <x-button type="outline-neutral" wire:click="changePassword"
                                addClasses="px-4 h-10 whitespace-nowrap w-full">Change
                            </x-button>
                        </div>
                    </div>
                    <x-input.text label="Bank" name="bank_name"
                        value="{{ $user->buyer->bank_name ?? $user->seller->bank_name }}" wire:model="bank_name"
                        :required="true" />
                    <x-input.text label="Bank Account Number" name="bank_account_number"
                        value="{{ $user->buyer->bank_account_number ?? $user->seller->bank_account_number }}"
                        wire:model="bank_account_number" :required="true" />
                </div>
                <div class="grid grid-cols-1 gap-4" x-show="tab === 'company'">
                    <x-input.text label="Company Name" name="company_name"
                        value="{{ $user->buyer->company_name ?? $user->seller->company_name }}"
                        wire:model="company_name" :required="true" />
                    @if ($user->isSeller())
                        <x-input.text label="NPWP" name="npwp" value="{{ $user->seller->npwp }}"
                            wire:model="npwp" :required="true" />
                        <x-input.text label="NIB" name="nib" value="{{ $user->seller->nib }}"
                            wire:model="nib" :required="true" />
                    @else
                        <x-input.text label="Country" name="country"
                            value="{{ $user->buyer->country ?? $user->seller->country }}" wire:model="country"
                            :required="true" />
                    @endif
                    <x-input.tel label="Company Phone Number" name="company_phone_number"
                        wire:model="company_phone_number"
                        value="{{ $user->buyer->company_phone_number ?? $user->seller->company_phone_number }}"
                        :required="true" />
                    <x-input.text label="Company Address" name="company_address" wire:model="company_address"
                        value="{{ $user->buyer->company_address ?? $user->seller->company_address }}"
                        :required="true" />
                    @if ($user->isSeller())
                        <div>
                            <span class="block mb-2 text-sm tracking-wide text-gray-500">Scan Surat Rekomendasi Dinas
                                Provinsi</span>
                            <div x-data="{ dropdownOpen: false }" class="relative">

                                <button @click="dropdownOpen = true"
                                    class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">
                                    <x-heroicon-o-document class="w-5 h-5 mr-3" />
                                    {{ $user->seller->recommendationLetterFile ? str_replace('uploads/', '', $user->seller->recommendationLetterFile->file_path) : 'file.pdf' }}
                                    <x-heroicon-c-ellipsis-vertical class="w-5 h-5 ml-3" />
                                </button>

                                <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                                    x-transition:enter="ease-out duration-200"
                                    x-transition:enter-start="-translate-y-2" x-transition:enter-end="translate-y-0"
                                    class="absolute top-full left-0 mt-2 z-50 w-56" x-cloak>
                                    <div
                                        class="p-1 mt-1 text-sm bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                                        <a href="/view-file/{{ $user->seller->recommendationLetterFile->id ?? '' }}"
                                            @click="dropdownOpen = false"
                                            class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                            <span>Open File</span>
                                        </a>
                                        <button
                                            @click="dropdownOpen = false; $dispatch('open-modal', 'update-recommendation-letter')"
                                            class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                            <span>Edit File</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div>
                            <span class="block mb-2 text-sm tracking-wide text-gray-500">Scan Surat Legalitas
                                Usaha</span>
                            <div x-data="{ dropdownOpen: false }" class="relative">

                                <button @click="dropdownOpen = true"
                                    class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">
                                    <x-heroicon-o-document class="w-5 h-5 mr-3" />
                                    {{ $user->buyer->legalityFile ? str_replace('uploads/', '', $user->buyer->legalityFile->file_path) : 'file.pdf' }}
                                    <x-heroicon-c-ellipsis-vertical class="w-5 h-5 ml-3" />
                                </button>

                                <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                                    x-transition:enter="ease-out duration-200"
                                    x-transition:enter-start="-translate-y-2" x-transition:enter-end="translate-y-0"
                                    class="absolute top-full left-0 mt-2 z-50 w-56" x-cloak>
                                    <div
                                        class="p-1 mt-1 text-sm bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                                        <a href="/view-file/{{ $user->buyer->legalityFile->id ?? '' }}"
                                            @click="dropdownOpen = false"
                                            class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                            <span>Open File</span>
                                        </a>
                                        <button
                                            @click="dropdownOpen = false; $dispatch('open-modal', 'update-legality-file')"
                                            class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                            <span>Edit File</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

    </div>
    <div class="flex flex-row gap-4 justify-end mt-8">
        <x-button type="outline-neutral" addClasses="px-8" button="button">Cancel</x-button>
        <x-button type="primary" addClasses="px-8" wire:click="save">Save</x-button>
    </div>

    <x-modal name="update-profile" :show="false" title="Update profile picture" :withIcon="false">
        <div class="p-3 grid grid-cols-1 justify-between items-center gap-4">
            <livewire:input.file-upload name="profile_picture" label="Upload Profile Picture" :transparent="false"
                user_id="{{ $user->id }}" wire:model="profile_picture" :required="true" />
            @error('profile_picture')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            <button type="button" wire:click="updateProfilePicture"
                x-on:click="$dispatch('close-modal', 'update-profile')"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-ecstasy rounded-lg hover:bg-ecstasy-600 focus:ring-2 focus:ring-offset-2 focus:ring-ecstasy-700 focus:shadow-outline focus:outline-none">
                Update Profile Picture
            </button>
        </div>
    </x-modal>
    <x-modal name="update-ktp" :show="false" title="Update KTP" :withIcon="false">
        <div class="p-3 grid grid-cols-1 justify-between items-center gap-4">
            <livewire:input.file-upload name="user_ktp" label="Upload Scan KTP" :transparent="false"
                user_id="{{ $user->id }}" wire:model="user_ktp" :required="true" />
            @error('user_ktp')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            <button type="button" wire:click="updateKTP"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-ecstasy rounded-lg hover:bg-ecstasy-600 focus:ring-2 focus:ring-offset-2 focus:ring-ecstasy-700 focus:shadow-outline focus:outline-none">
                Update KTP
            </button>
        </div>
    </x-modal>
    <x-modal name="update-legality-file" :show="false" title="Update Surat Legalitas" :withIcon="false">
        <div class="p-3 grid grid-cols-1 justify-between items-center gap-4">
            <livewire:input.file-upload name="legality_file_buyer" label="Upload Surat Legalitas" :transparent="false"
                user_id="{{ $user->id }}" wire:model="legality_file_buyer" :required="true" />
            @error('legality_file_buyer')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            <button type="button" wire:click="updateLegalityFile"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-ecstasy rounded-lg hover:bg-ecstasy-600 focus:ring-2 focus:ring-offset-2 focus:ring-ecstasy-700 focus:shadow-outline focus:outline-none">
                Update Legality File
            </button>
        </div>
    </x-modal>
    <x-modal name="update-recommendation-letter" :show="false" title="Update Surat Rekomendasi"
        :withIcon="false">
        <div class="p-3 grid grid-cols-1 justify-between items-center gap-4">
            <livewire:input.file-upload name="recommendation_letter_seller" label="Upload Surat Rekomendasi"
                :transparent="false" user_id="{{ $user->id }}" wire:model="recommendation_letter_seller"
                :required="true" />
            @error('recommendation_letter_seller')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            <button type="button" wire:click="updateRecommendationLetter"
                class="inline-flex items-center justify-center px-8 py-3 font-medium tracking-wide text-white transition-colors duration-200 bg-ecstasy rounded-lg hover:bg-ecstasy-600 focus:ring-2 focus:ring-offset-2 focus:ring-ecstasy-700 focus:shadow-outline focus:outline-none">
                Update Recommendation Letter File
            </button>
        </div>
    </x-modal>
</div>
