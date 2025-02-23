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
                <x-button class="font-semibold text-lg" type="primary">Detail</x-button>
                <x-button class="font-semibold text-lg" type="secondary">Account</x-button>
                <x-button class="font-semibold text-lg" type="secondary">Company</x-button>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <x-input.text label="Your Name" name="name" value="John Doe" :required="true" />
                <x-input.text label="NIK" name="nik" value="xxxxxxxxxxxxx" :required="true" />
                <x-input.tel label="Phone Number" name="phone_number" value="xxxxxxxxxxxxx" :required="true" />
                <x-input.text label="Address" name="address" value="Jalan Surabaya" :required="true" />
            </div>
        </div>
</x-layouts.dashboard>
