<div>
    <div class="fixed top-0 left-0 h-screen bg-mainGreen text-white transition-all duration-300"
        :class="{ 'w-72': sidebarOpenStatus, 'w-16': !sidebarOpenStatus }">

        <div class="flex justify-end items-center px-4 py-3">
            <button @click="toggle" type="button" class="text-neutral-200 p-2 transition-all">
                <x-heroicon-o-chevron-double-left class="w-6 h-6 transform" ::class="{ 'rotate-0': sidebarOpenStatus, 'rotate-180': !sidebarOpenStatus }" />
            </button>
        </div>

        <!-- Logo Section -->
        <div class="flex items-center justify-center py-3">
            <img src="{{ asset('images/logo.svg') }}" alt="logo" class="w-12 h-12" />
            <h1 class="ml-3 text-lg font-bold transition-all"
                :class="{ 'block': sidebarOpenStatus, 'hidden': !sidebarOpenStatus }">
                Explora Nusantara
            </h1>
        </div>

        <!-- User Info -->
        <div class="flex items-center px-4 py-3">
            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->username }}" alt="User"
                class="w-12 h-12 rounded-full transition-all"
                :class="{ 'w-12 h-12': sidebarOpenStatus, 'w-8 h-8': !sidebarOpenStatus }" />
            <div class="ml-3 transition-all" :class="{ 'block': sidebarOpenStatus, 'hidden': !sidebarOpenStatus }">
                <h2 class="text-base font-semibold">{{ auth()->user()->username }}</h2>
                <p class="text-sm text-gray-300">{{ auth()->user()->username }}@gmail.com</p>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="mt-3">
            <ul>
                @if (auth()->user()->role === \App\Enums\UserRole::ADMIN)
                    <x-layouts.sidebar.sidebar-item route="{{ route('home') }}" :title="'Home'" :active="request()->routeIs('dashboard')"
                        icon="heroicon-s-home" :isSubmenu="false" />
                    <x-layouts.sidebar.sidebar-item route="{{ route('user-profile') }}" :title="'Profile'"
                        :active="request()->routeIs('user-profile')" icon="heroicon-s-user" :isSubmenu="false" />
                    <x-layouts.sidebar.item-dropdown icon="heroicon-s-clipboard-document-check" title="Validation"
                        >
                        <x-layouts.sidebar.sidebar-item route="{{ route('admin.product.index') }}" :title="'Product'"
                            :active="request()->routeIs('admin.product.*')" icon="heroicon-s-shopping-cart" :isSubmenu="true" />
                        <x-layouts.sidebar.sidebar-item route="{{ route('admin.transaction.index') }}"
                            :title="'Transaction'" :active="request()->routeIs('admin.transaction.*')" icon="heroicon-s-wallet" :isSubmenu="true" />
                        <x-layouts.sidebar.sidebar-item route="{{ route('admin.trade-meeting.index') }}"
                            :title="'Trade Meeting'" :active="request()->routeIs('admin.trade-meeting.*')" icon="heroicon-s-chat-bubble-bottom-center-text"
                            :isSubmenu="true" />
                        <x-layouts.sidebar.sidebar-item route="{{ route('admin.contract.index') }}" :title="'Contract'"
                            :active="request()->routeIs('admin.contract.*')" icon="heroicon-o-document" :isSubmenu="true" />
                    </x-layouts.sidebar.item-dropdown>
                    <x-layouts.sidebar.sidebar-item route="{{ route('tutorial') }}" :title="'Tutorial'"
                        :active="request()->routeIs('tutorial')" icon="heroicon-s-light-bulb" :isSubmenu="false" />
                @elseif(auth()->user()->role === \App\Enums\UserRole::BUYER)
                    <x-layouts.sidebar.sidebar-item route="{{ route('home') }}" :title="'Home'" :active="request()->routeIs('dashboard')"
                        icon="heroicon-s-home" :isSubmenu="false" />
                    <x-layouts.sidebar.sidebar-item route="{{ route('user-profile') }}" :title="'Profile'"
                        :active="request()->routeIs('user-profile')" icon="heroicon-s-user" :isSubmenu="false" />
                    <x-layouts.sidebar.sidebar-item route="{{ route('buyer.product.index') }}" :title="'Product'"
                        :active="request()->routeIs('buyer.product.*')" icon="heroicon-s-shopping-cart" :isSubmenu="false" />
                    <x-layouts.sidebar.sidebar-item route="{{ route('buyer.transaction.index') }}" :title="'Transaction'" :chatCount="auth()->user()->getUserUnreadChatsCount()"
                        :active="request()->routeIs('buyer.transaction.*')" icon="heroicon-s-wallet" :isSubmenu="false" />
                    <x-layouts.sidebar.sidebar-item route="{{ route('buyer.trade-meeting.index') }}" :title="'Trade Meeting'"
                        :active="request()->routeIs('buyer.trade-meeting.index')" icon="heroicon-s-chat-bubble-bottom-center-text" :isSubmenu="false" />
                    <x-layouts.sidebar.sidebar-item route="{{ route('tutorial') }}" :title="'Tutorial'"
                        :active="request()->routeIs('tutorial')" icon="heroicon-s-light-bulb" :isSubmenu="false" />
                @elseif(auth()->user()->role === \App\Enums\UserRole::SELLER)
                    <x-layouts.sidebar.sidebar-item route="{{ route('home') }}" :title="'Home'" :active="request()->routeIs('dashboard')"
                        icon="heroicon-s-home" :isSubmenu="false" />
                    <x-layouts.sidebar.sidebar-item route="{{ route('user-profile') }}" :title="'Profile'"
                        :active="request()->routeIs('user-profile')" icon="heroicon-s-user" :isSubmenu="false" />
                    <x-layouts.sidebar.sidebar-item route="{{ route('seller.product.index') }}" :title="'Product'"
                        :active="request()->routeIs('seller.product.*')" icon="heroicon-s-shopping-cart" :isSubmenu="false" />
                    <x-layouts.sidebar.sidebar-item route="{{ route('seller.transaction.index') }}" :title="'Transaction'"
                        :active="request()->routeIs('seller.transaction.*')" icon="heroicon-s-wallet" :isSubmenu="false" :chatCount="auth()->user()->getUserUnreadChatsCount()" />
                    <x-layouts.sidebar.sidebar-item route="{{ route('seller.trade-meeting.index') }}"
                        :title="'Trade Meeting'" :active="request()->routeIs('seller.trade-meeting.*')" icon="heroicon-s-chat-bubble-bottom-center-text"
                        :isSubmenu="false" />
                    <x-layouts.sidebar.sidebar-item route="{{ route('tutorial') }}" :title="'Tutorial'"
                        :active="request()->routeIs('tutorial')" icon="heroicon-s-light-bulb" :isSubmenu="false" />
                @endif
            </ul>
        </nav>

        <div class="h-max-screen flex items-end justify-center py-6 my-8">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center px-5 py-3 text-gray-300 hover:bg-ecstasy hover:text-white"
                    :class="{ 'rounded-lg': sidebarOpenStatus }" type="submit">
                    <x-heroicon-c-arrow-left-end-on-rectangle class="w-6 h-6" />
                    <span class="ml-3 transition-all"
                        :class="{ 'block': sidebarOpenStatus, 'hidden': !sidebarOpenStatus }">
                        Log Out
                    </span>
                </button>
            </form>
        </div>
    </div>

</div>
