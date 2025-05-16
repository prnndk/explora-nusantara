<x-layouts.dashboard webTitle="Dashboard Buyer">
    <h1 class="text-4xl font-bold">Selamat Datang! Buyer, di Explora Nusantara</h1>

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
                <x-dashboard-statistic title="Contracts in force" heading="{{ $unvalidatedContract }}"
                    icon="heroicon-o-globe-asia-australia" color="primary" />
                <x-dashboard-statistic title="Ongoing transactions"
                    heading="Rp {{ number_format($ongoingTransaction, 0, ',', '.') }}" icon="heroicon-m-banknotes"
                    color="secondary" />
                <x-dashboard-statistic title="Verified Meetings" :heading="$unvalidatedMeeting" :smallNumber="$totalMeeting"
                    icon="heroicon-o-chat-bubble-left-right" color="secondary" />
                <x-dashboard-statistic title="Expired Transaction" :heading="$expiredTransaction" icon="heroicon-m-lock-closed"
                    color="primary" />
            </div>
            <div class="mt-8">
                <x-dashboard-chart :chart_data="$transactionChart" />
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
                    @foreach ($newestMeeting as $meet)
                        <x-dashboard-notification heading="Zoom Meeting" description="With {{ $meet->buyer->name }}"
                            icon="heroicon-o-chat-bubble-left-right" color="secondary" :link="route('buyer.trade-meeting.index')" />
                    @endforeach

                    @foreach ($newestTransaction as $transaction)
                        <x-dashboard-notification heading="Product {{ $transaction->status }}"
                            description="Buyer: {{ $transaction->buyer->name }} Seller: {{ $transaction->seller->name }}"
                            icon="heroicon-o-archive-box" :link="route('buyer.transaction.detail', $transaction->id)" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
