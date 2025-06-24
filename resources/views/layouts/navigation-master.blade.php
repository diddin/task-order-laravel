<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Sidebar -->
    <div class="w-64 h-screen bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 fixed top-0 left-0 flex flex-col justify-between px-4 py-6
        ">
        <!-- Top (Logo + Nav) -->
        <div>
            <!-- Logo -->
            <div class="flex items-center justify-center mb-6">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex flex-col space-y-2">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link :href="route('master.admins.index')" :active="request()->routeIs('master.admins.index')">
                    {{ __('Admin') }}
                </x-nav-link>
                <x-nav-link :href="route('master.technicians.index')" :active="request()->routeIs('master.technicians.index')">
                    {{ __('Teknisi') }}
                </x-nav-link>
                <x-nav-link :href="route('master.customers.index')" :active="request()->routeIs('master.customers.index')">
                    {{ __('Pelanggan') }}
                </x-nav-link>
                <x-nav-link :href="route('master.networks.index')" :active="request()->routeIs('master.networks.index')">
                    {{ __('Jaringan') }}
                </x-nav-link>
                <x-nav-link :href="route('master.tasks.index')" :active="request()->routeIs('master.tasks.index')">
                    {{ __('Tiket') }}
                </x-nav-link>
            </nav>
        </div>

        <!-- Bottom (User Dropdown) -->
        <div class="relative">
            <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <button class="w-full text-left inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        <div class="flex-1">{{ Auth::user()->name }}</div>
                        <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('master.profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('master.admins.index')" :active="request()->routeIs('master.admins.index')">
                {{ __('Admin') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('master.technicians.index')" :active="request()->routeIs('master.technicians.index')">
                {{ __('Admin') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('master.customers.index')" :active="request()->routeIs('master.customers.index')">
                {{ __('Pelanggan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('master.networks.index')" :active="request()->routeIs('master.networks.index')">
                {{ __('Jaringan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('master.tasks.index')" :active="request()->routeIs('master.tasks.index')">
                {{ __('Tiket') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('master.profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        <!-- Mobile Sidebar Button (Hamburger) -->
        <div class="sm:hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-4 flex justify-between">
            <x-application-logo class="h-8 fill-current text-gray-800 dark:text-gray-200" />

            <button @click="open = !open" class="text-gray-600 dark:text-gray-400">
                <!-- Hamburger icon -->
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Sidebar -->
        <div x-show="open" class="sm:hidden fixed inset-0 z-40 bg-white dark:bg-gray-900 p-6 space-y-4 overflow-y-auto">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" @click="open = false">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <!-- ... other links ... -->
            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </x-responsive-nav-link>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</nav>
