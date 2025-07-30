<!-- header -->
<div class="avara-header">
    <div class="container">
        <div class="grid grid-cols-2 gap-4 px-5 py-3">
            <a href="{{ route('technician.dashboard') }}" class="avara-logo"><img src="{{ asset('images/logo.png') }}" alt="avara logo"></a>
            <div class="flex items-center justify-end gap-x-4">
                <a href="{{ route('technician.profile.edit') }}"
                class="header-profile cursor-pointer transition-transform duration-200 hover:-translate-y-1 hover:shadow-lg">
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
                @php
                    $totalUnread = ($unreadTaskCount ?? 0) + ($unreadChatCount ?? 0);
                @endphp

                <a href="{{ route('notifications.index') }}" 
                    class="header-notif relative cursor-pointer transition-transform duration-200 hover:-translate-y-1 hover:shadow-lg">
                    <span class="ri-notification-2-fill"></span>
                    @if($totalUnread > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                            {{ $totalUnread }}
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
                <li><a href="{{ route('technician.dashboard') }}" class="hover:bg-gray-200 hover:text-black">Beranda</a></li>
                <li><a href="{{ route('technician.tasks.index') }}" class="hover:bg-gray-200 hover:text-black">Aktifitas</a></li>
                <li><a href="{{ route('notifications.index') }}" class="hover:bg-gray-200 hover:text-black">Pemberitahuan</a></li>
                <li><a href="{{ route('chats.index') }}" class="hover:bg-gray-200 hover:text-black">Kontak Admin</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            Keluar <span class="ri-logout-box-r-line"></span>
                        </x-responsive-nav-link>
                        
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>