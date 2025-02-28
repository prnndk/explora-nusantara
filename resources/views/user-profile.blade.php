<x-layouts.dashboard webTitle="User Profile">
    <h1 class="text-4xl font-bold">Buyer Profile</h1>
    <h6 class="">Easily manage your account information and preferences in one intuitive and personalized place.
    </h6>

    <div class="grid md:grid-cols-2 gap-4 mt-8">

        {{-- Image Profile --}}
        <div class="flex flex-col justify-center items-center gap-4">
            <img src="https://ui-avatars.com/api/?name=export-trade-gate" alt="User"
                class="w-48 h-48 rounded-full transition-all" />
            <x-button class="font-semibold text-lg flex items-center gap-2" type="primary">Buyer
                <x-heroicon-c-pencil-square class="w-5 h-5" />
            </x-button>
        </div>

        {{-- Tab --}}
        <div class="flex flex-col gap-4">
            <div class="flex gap-10">
                <a href="" class="text-lg font-semibold">Detail</a>
                <a href="" class="text-lg">Account</a>
                <a href="" class="text-lg">Company</a>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <x-input.text label="Your Name" name="name" value="John Doe" :required="true" />
                <x-input.text label="NIK" name="nik" value="xxxxxxxxxxxxx" :required="true" />
                <x-input.tel label="Phone Number" name="phone_number" value="xxxxxxxxxxxxx" :required="true" />
                <x-input.text label="Address" name="address" value="Jalan Surabaya" :required="true" />
                <div x-data="{
                    dropdownOpen: false
                }" class="relative">

                    <button @click="dropdownOpen=true"
                        class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">
                        <x-heroicon-o-document class="w-5 h-5 mr-3" />file.pdf <x-heroicon-c-ellipsis-vertical
                            class="w-5 h-5 ml-3" />
                    </button>

                    <div x-show="dropdownOpen" @click.away="dropdownOpen=false"
                        x-transition:enter="ease-out duration-200" x-transition:enter-start="-translate-y-2"
                        x-transition:enter-end="translate-y-0" class="absolute top-0 z-50 w-56 mt-2 left-0" x-cloak>
                        <div
                            class="p-1 mt-1 text-sm bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                            <a href="#_" @click="menuBarOpen=false"
                                class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none data-[disabled]:opacity-50 data-[disabled]:pointer-events-none">
                                <span>Download File</span>
                            </a>
                            <a href="#_" @click="menuBarOpen=false"
                                class="relative flex justify-between w-full cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 hover:text-neutral-900 outline-none data-[disabled]:opacity-50 data-[disabled]:pointer-events-none">
                                <span>Delete File</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-layouts.dashboard>
