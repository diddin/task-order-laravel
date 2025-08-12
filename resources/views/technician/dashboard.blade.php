<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container">
        <div class="wrapper">
            <div class="flex flex-wrap items-center justify-between gap-2 sm:gap-4 px-2">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Tiket baru untuk anda</h3>
                <form action="{{ route('notifications.markAllTasksAsRead') }}" method="POST">
                    @csrf
                    <button 
                        type="submit"
                        class="{{ $unreadTaskCount != 0 ? 'font-bold text-blue-500 hover:text-blue-800 text-sm focus:outline-none' : 'text-gray-300 cursor-not-allowed text-sm' }} text-xs"
                        title="Tandai semua dibaca"
                        {{ $unreadTaskCount == 0 ? 'disabled' : '' }}
                    >
                        Tandai Semua Dibaca
                    </button>
                </form>
            </div>
            @foreach ($tasks['newTasks'] as $task)
                @php
                    $assignedUser = $task->assignedUsers->first();
                    $isUnread = $assignedUser && !$assignedUser->pivot->is_read;
                @endphp
                <a href="{{ route('technician.taskorders.progress', $task ) }}" 
                    class="content-shadow hover:bg-gray-100
                    {{ $isUnread ? 'ring-2 ring-blue-400 hover:bg-gray-100' : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    <h2>{{ $task->customer?->name ?? 'Backbone' }}</h2>
                    <div class="icon-text">
                        <span class="ri-map-pin-line"></span>
                        <p>{{ $task->customer?->address ?? '-' }}</p>
                    </div>
                    {{-- <div class="icon-text">
                        <span class="ri-corner-right-up-line"></span>
                        <p>Akses: FO B2B to Curug</p>
                    </div> --}}
                    <div class="eta-footer group-between">
                        <span class="text-gray-700">
                            <span class="ri-calendar-line"></span>
                            {{ $task->created_at->translatedFormat('d F Y') }}
                        </span>
                        <span class="text-red-700">
                            <span class="ri-time-line"></span>
                            {{ $task->remaining }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="wrapper">
            <div class="mb-2 group-between px-2">
                <h3>Aktifitas Anda</h3>
                <a href="{{ route('technician.tasks.index') }}" 
                    class="flex items-center gap-2 text-blue-700 hover:text-blue-900 transition-all duration-200 group">
                    <span class="text-xs">Lihat Semua</span>
                    <span class="ri-arrow-right-long-fill transform transition-transform duration-200 group-hover:translate-x-1"></span>
                </a>
            </div>
            @foreach($tasks['myActivities'] as $task)
                <div class="content-shadow">
                    <h5>
                        {{-- <span class="ri-map-pin-line"></span> --}}
                        {{ $task->customer?->name ?? 'Backbone' }}
                    </h5>
                    <div class="group-between">
                        <span class="text-gray-700">
                            <span class="ri-calendar-line"></span>
                            {{ $task->created_at->translatedFormat('d F Y') }}
                        </span>
                        @if($task->action === 'completed')
                            <span class="text-green-700">
                                <span class="ri-check-line"></span>
                                Selesai
                            </span>
                        @elseif($task->action === 'in progress')
                            <span class="text-yellow-700">
                                <span class="ri-time-line"></span>
                                Dalam Proses
                            </span>
                        @else
                            <span class="text-red-700">
                                <span class="ri-close-line"></span>
                                Tidak Tercapai
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-dynamic-layout>