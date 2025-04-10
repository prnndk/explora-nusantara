<x-layouts.dashboard webTitle="Dashboard">
    <h1 class="text-4xl font-bold">Selamat Datang! {{ ucfirst(auth()->user()->role->value) }}, di Explora Nusantara</h1>

    <section class="flex justify-center mt-8 w-full" id="slider_banner">
        {{-- sliding image banner --}}
        <div class="relative w-full h-64">
            <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=1471&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="banner" class="w-full h-full object-cover rounded-3xl" />
        </div>
    </section>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
        <div class="flex flex-col h-full w-full col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12"
                :class="{ 'gap-12': !sidebarOpenStatus, 'gap-8': sidebarOpenStatus }">
                @if (auth()->user()->role == App\Enums\UserRole::ADMIN)
                    <x-dashboard-statistic title="Unvalidated Contracts" heading=12
                        icon="heroicon-o-globe-asia-australia" color="primary" />
                    <x-dashboard-statistic title="Unvalidated transactions" heading="$123.12"
                        icon="heroicon-m-banknotes" color="secondary" />
                    <x-dashboard-statistic title="Unvalidated Meetings" heading="9" smallNumber="11"
                        icon="heroicon-o-chat-bubble-left-right" color="secondary" />
                    <x-dashboard-statistic title="Unvalidated Products" heading="3" icon="heroicon-c-archive-box"
                        color="primary" />
                @elseif (auth()->user()->role == App\Enums\UserRole::BUYER)
                    <x-dashboard-statistic title="Contracts in force" heading=12 icon="heroicon-o-globe-asia-australia"
                        color="primary" />
                    <x-dashboard-statistic title="Ongoing transactions" heading="$123.12" icon="heroicon-m-banknotes"
                        color="secondary" />
                    <x-dashboard-statistic title="Verified Meetings" heading="9" smallNumber="11"
                        icon="heroicon-o-chat-bubble-left-right" color="secondary" />
                    <x-dashboard-statistic title="Expired Transaction" heading="3" icon="heroicon-m-lock-closed"
                        color="primary" />
                @elseif (auth()->user()->role == App\Enums\UserRole::SELLER)
                    <x-dashboard-statistic title="Contracts in force" heading=12 icon="heroicon-o-globe-asia-australia"
                        color="primary" />
                    <x-dashboard-statistic title="Ongoing transactions" heading="$123.12" icon="heroicon-m-banknotes"
                        color="secondary" />
                    <x-dashboard-statistic title="Verified Meetings" heading="9" smallNumber="11"
                        icon="heroicon-o-chat-bubble-left-right" color="secondary" />
                    <x-dashboard-statistic title="Verified Products" heading="23" smallNumber="30"
                        icon="heroicon-c-archive-box" color="primary" />
                @endif

            </div>
            <div class="mt-8">
                <x-dashboard-chart />
            </div>
        </div>
        <div class="flex flex-col h-full w-full col-span-1">
            <div class="">
                <h6 class="font-bold text-xl">Calendar</h6>
                <x-calendar />
            </div>
            <div class="">
                <h6 class="font-bold text-xl">Notification</h6>
                <div class="flex flex-col my-4 gap-4">
                    <h6 class="text-sm text-neutral-400">Today</h6>
                    <x-dashboard-notification heading="Zoom Meeting" description="With Singapore Client"
                        icon="heroicon-o-chat-bubble-left-right" color="secondary" />
                </div>
                <div class="flex flex-col my-4 gap-4">
                    <h6 class="text-sm text-neutral-400">Yesterday</h6>
                    <x-dashboard-notification heading="Product Purchase" description="Product successfully paid"
                        icon="heroicon-o-archive-box" />
                    <x-dashboard-notification heading="Product Purchase" description="Product successfully paid"
                        icon="heroicon-o-archive-box" />
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
