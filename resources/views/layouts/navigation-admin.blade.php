<nav x-data="{ open: false }">
    <!-- Desktop Sidebar -->
    <div class="hidden sm:flex w-64 h-screen bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 fixed top-0 left-0 flex-col justify-between px-4 py-6">
        <!-- Logo -->
        <div>
            <div class="flex items-center justify-center mb-6 mt-10">
                <a href="{{ route('admin.dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex flex-col space-y-2 mt-10">
                {{-- <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Dashboard</x-nav-link> --}}
                <x-nav-link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.index')">Jaringan</x-nav-link>
                {{-- <x-nav-link :href="route('admin.networks.index')" :active="request()->routeIs('admin.networks.index')">Jaringan</x-nav-link> --}}
                <x-nav-link :href="route('admin.tasks.index')" :active="request()->routeIs('admin.tasks.index')">Tiket</x-nav-link>
                <x-nav-link :href="route('admin.announcements.index')" :active="request()->routeIs('admin.announcements.index')">Pengumuman</x-nav-link>
                <x-nav-link :href="route('task.report')" :active="request()->routeIs('task.report')">Laporan Tiket</x-nav-link>
                <x-nav-link :href="route('chats.index')" :active="request()->routeIs('chats.index')">Kontak Teknisi</x-nav-link>
            </nav>
        </div>

        <!-- User Dropdown -->
        <div class="relative">
            <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <button class="w-full text-left inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 transition">
                        <div class="flex-1">{{ Auth::user()->name }}</div>
                        <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('admin.profile.edit')">Profil</x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Keluar</x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>

    <!-- Mobile Topbar -->
    <div class="sm:hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-4 flex justify-between items-center fixed top-0 left-0 right-0 z-50">
        <x-application-logo class="h-8 fill-current text-gray-800 dark:text-gray-200" />
        <button @click="open = !open" class="text-gray-600 dark:text-gray-400 focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Mobile Sidebar Overlay -->
    {{-- <div x-show="open"
         x-transition.opacity
         class="sm:hidden fixed inset-0 bg-black bg-opacity-50 z-40"
         @click="open = false">
    </div> --}}

    <!-- Mobile Sidebar -->
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-x-full"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-full"
        class="sm:hidden fixed top-16 left-0 right-0 bottom-0 z-40 bg-white dark:bg-gray-900 p-6 space-y-4 overflow-y-auto"
    >
        {{-- <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" @click="open = false">Dashboard</x-responsive-nav-link> --}}
        <x-responsive-nav-link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.index')" @click="open = false">Jaringan</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.tasks.index')" :active="request()->routeIs('admin.tasks.index')" @click="open = false">Tiket</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.announcements.index')" :active="request()->routeIs('admin.announcements.index')" @click="open = false">Pengumuman</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('task.report')" :active="request()->routeIs('task.report')" @click="open = false">Laporan Tiket</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('chats.index')" :active="request()->routeIs('chats.index')" @click="open = false">Kontak Teknisi</x-responsive-nav-link>
        
        <div class="border-t pt-4">
            <x-responsive-nav-link :href="route('admin.profile.edit')" @click="open = false">Profil</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</x-responsive-nav-link>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</nav>
