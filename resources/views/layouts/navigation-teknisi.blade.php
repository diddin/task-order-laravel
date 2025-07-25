<!-- header -->
<div class="avara-header">
    <div class="container">
        <div class="grid grid-cols-2 gap-4 px-5 py-3">
            <a href="{{ route('technician.dashboard') }}" class="avara-logo"><img src="{{ asset('images/logo.png') }}" alt="avara logo"></a>
            <div class="flex items-center justify-end gap-x-4">
                <a class="header-profile" href="{{ route("technician.profile.edit") }}">
                    <div class="photo">
                        @if (auth()->user()->profile_image)
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile Image">
                        @else
                            <span class="ri-user-line"></span>
                        @endif
                    </div>
                    <div class="profile-name">
                        <span>Halo</span>
                        <span class="name">{{ auth()->user()->name }}</span>
                    </div>
                </a>
                <a href="{{ route("notifications.index") }}" class="header-notif relative">
                    <span class="ri-notification-2-fill"></span>
                    @if($unreadTaskCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                            {{ $unreadTaskCount }}
                        </span>
                    @endif
                </a>
                <div class="header-menu">
                    <span class="ri-menu-line"></span>
                </div>
            </div>
        </div>
        <div class="navbar-content">
            <ul class="navbar-list">
                <li><a href="{{ route('technician.dashboard') }}">Beranda</a></li>
                <li><a href="{{ route('technician.tasks.index') }}">Aktifitas</a></li>
                <li><a href="{{ route('notifications.index') }}">Pemberitahuan</a></li>
                <li><a href="{{ route('chat.technician-index') }}">Kontak Admin</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Keluar</x-responsive-nav-link>
                    </form>
                    {{-- <a href="#">Keluar <span class="ri-logout-box-r-line"></span></a> --}}
                </li>
            </ul>
        </div>
    </div>
</div>