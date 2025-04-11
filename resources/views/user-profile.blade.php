<x-layouts.dashboard webTitle="User Profile">
    <h1 class="text-4xl font-bold">Buyer Profile</h1>
    <h6>Easily manage your account information and preferences in one intuitive and personalized place.
    </h6>

    <div class="grid md:grid-cols-2 gap-4 mt-8 min-h-full">
        <div class="flex flex-col items-center gap-4">
            <img src="https://ui-avatars.com/api/?name={{auth()->user()->username}}" alt="User"
                class="w-48 h-48 rounded-full transition-all" />
            <span class="font-semibold text-lg flex items-center gap-2" type="primary">Buyer
                <x-heroicon-c-pencil-square class="w-5 h-5" />
            </span>
        </div>

        <div class="flex flex-col gap-4" x-data="{ tab: 'detail' }">
            <div class="flex gap-10">
                <button @click="tab = 'detail'" class="text-lg"
                    :class="{ 'font-semibold': tab === 'detail' }">Detail</button>
                <button @click="tab = 'account'" class="text-lg"
                    :class="{ 'font-semibold': tab === 'account' }">Account</button>
                <button @click="tab = 'company'" class="text-lg"
                    :class="{ 'font-semibold': tab === 'company' }">Company</button>
            </div>

            <div class="grid grid-cols-1 gap-4" x-show="tab === 'detail'">
                <x-input.text label="Your Name" name="name" value="John Doe" :required="true" />
                <x-input.text label="NIK" name="nik" value="xxxxxxxxxxxxx" :required="true" />
                <x-input.tel label="Phone Number" name="phone_number" value="xxxxxxxxxxxxx" :required="true" />
                <x-input.text label="Address" name="address" value="Jalan Surabaya" :required="true" />
                <div>
                    <span class="block mb-2 text-sm tracking-wide text-gray-500">Scan KTP</span>
                    <div x-data="{ dropdownOpen: false }" class="relative">

                        <button @click="dropdownOpen = true"
                            class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">
                            <x-heroicon-o-document class="w-5 h-5 mr-3" />file.pdf <x-heroicon-c-ellipsis-vertical
                                class="w-5 h-5 ml-3" />
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                            x-transition:enter="ease-out duration-200" x-transition:enter-start="-translate-y-2"
                            x-transition:enter-end="translate-y-0" class="absolute top-full left-0 mt-2 z-50 w-56"
                            x-cloak>
                            <div
                                class="p-1 mt-1 text-sm bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                                <a href="#_" @click="dropdownOpen = false"
                                    class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                    <span>Download File</span>
                                </a>
                                <a href="#_" @click="dropdownOpen = false"
                                    class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                    <span>Delete File</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4" x-show="tab === 'account'">
                <div class="flex flex-row gap-2 items-end w-full">
                    <div class="w-5/6">
                        <x-input.text label="Email" name="email" value="buyer@gmail.com" :required="true"
                            class="flex-grow" />
                    </div>
                    <div class="w-1/6">
                        <x-button type="outline-ecstasy"
                            addClasses="px-4 h-10 whitespace-nowrap w-full">Verify</x-button>
                    </div>
                </div>
                <div class="flex flex-row gap-2 items-end w-full">
                    <div class="w-5/6">
                        <x-input.text label="Password" name="password" value="********" :required="true"
                            class="flex-grow" />
                    </div>
                    <div class="w-1/6">
                        <x-button type="outline-neutral"
                            addClasses="px-4 h-10 whitespace-nowrap w-full">Change</x-button>
                    </div>
                </div>
                <x-input.select label="Bank" name="bank" />
                <x-input.text label="Bank Account Number" name="bank_account_number" value="xxxxxxxx"
                    :required="true" />
            </div>
            <div class="grid grid-cols-1 gap-4" x-show="tab === 'company'">
                <x-input.text label="Company Name" name="company_name" value="PT Cinta sejati" :required="true" />
                <x-input.text label="Country" name="country" value="Indonesia" :required="true" />
                <x-input.tel label="Company Phone Number" name="company_phone_number" value="xxxxxxxxxxxxx"
                    :required="true" />
                <x-input.text label="Company Address" name="company_address" value="Jalan Surabaya"
                    :required="true" />
                <div>
                    <span class="block mb-2 text-sm tracking-wide text-gray-500">Scan Surat Legalitas Usaha</span>
                    <div x-data="{ dropdownOpen: false }" class="relative">

                        <button @click="dropdownOpen = true"
                            class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">
                            <x-heroicon-o-document class="w-5 h-5 mr-3" />file.pdf <x-heroicon-c-ellipsis-vertical
                                class="w-5 h-5 ml-3" />
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                            x-transition:enter="ease-out duration-200" x-transition:enter-start="-translate-y-2"
                            x-transition:enter-end="translate-y-0" class="absolute top-full left-0 mt-2 z-50 w-56"
                            x-cloak>
                            <div
                                class="p-1 mt-1 text-sm bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                                <a href="#_" @click="dropdownOpen = false"
                                    class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                    <span>Download File</span>
                                </a>
                                <a href="#_" @click="dropdownOpen = false"
                                    class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none">
                                    <span>Delete File</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-row gap-4 justify-end mt-8">
        <x-button type="outline-neutral" addClasses="px-8">Cancel</x-button>
        <x-button type="primary" addClasses="px-8">Save</x-button>
    </div>
</x-layouts.dashboard>
