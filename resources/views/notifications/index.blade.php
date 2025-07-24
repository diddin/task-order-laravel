<x-dynamic-layout>
    <div class="body-content">  
        <div class="container space-y-6">

            <a href="{{ route('technician.dashboard') }}" class="back-to inline-flex items-center mb-4 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                <span class="text-xl ri-arrow-left-s-line mr-1"></span>
                <span>Kembali</span>
            </a>

            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Pemberitahuan</h3>

            {{-- Announcements --}}
            <div class="content-shadow bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                @forelse ($notifications['announcements'] as $announcement)
                    <a href="{{ route('notifications.detail', ['id' => $announcement->id, 'type' => 'announcement']) }}" class="block mb-4 last:mb-0 hover:bg-gray-100 dark:hover:bg-gray-600 p-3 rounded-md transition">
                        <span class="block mb-2 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            {{ $announcement->created_at->format('d F Y') }}
                        </span>
                        <p class="!mb-0 text-gray-800 dark:text-gray-100 font-bold">{{ $announcement->title }}</p>
                        <p class="text-sm mt-1 text-gray-500 dark:text-gray-300 line-clamp-2">
                            {{ Str::limit(strip_tags($announcement->content), 100) }}
                        </p>
                    </a>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada pengumuman.</p>
                @endforelse

                {{-- Pagination for announcements --}}
                <div class="mt-4">
                    {{ $notifications['announcements']->links() }}
                </div>
            </div>

            <hr class="border-gray-300 dark:border-gray-600 mb-6">

            <div class="mb-4">
                <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Tiket Baru</h4>
            </div>

            {{-- Tasks --}}
            <div class="content-shadow bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                @forelse ($notifications['tasks'] as $task)
                    <a href="{{ route('notifications.detail', ['id' => $task->id, 'type' => 'task']) }}" class="block mb-4 last:mb-0 hover:bg-gray-200 dark:hover:bg-gray-700 p-3 rounded-md transition">
                        <span class="block mb-2 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            {{ $task->created_at->format('d F Y') }}
                        </span>
                        <p class="!mb-0 text-gray-800 dark:text-gray-100 font-bold">
                            {{ $task->network->customer->address }}
                        </p>
                        <p class="text-sm mt-1 text-gray-500 dark:text-gray-300 line-clamp-2">
                            {{ Str::limit(strip_tags($task->detail), 100) }}
                        </p>
                    </a>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada tiket baru.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-dynamic-layout>
{{-- <x-dynamic-layout>
    <div class="body-content">  
        <div class="container">
            <div class="wrapper">
                <a href="{{ route('technician.dashboard') }}" class="back-to">
                    <span class="text-xl ri-arrow-left-s-line"></span>
                    <span>Kembali</span>
                </a>
                <h3>Pemberitahuan</h3>
                <a class="content-shadow" href="{{ route('notifications.detail', ['id' => 1]) }}">
                    <span class="block mb-2 text-xs font-semibold text-gray-600">12 Juni 2025</span>
                    <h5 class="!mb-0">Kantor Pos Jaya Baru - Srengseng Sawah</h5>
                </a>
                <a class="content-shadow" href="{{ route('notifications.detail', ['id' => 2]) }}">
                    <span class="block mb-2 text-xs font-semibold text-gray-600">12 Juni 2025</span>
                    <h5 class="!mb-0">Bank BRI Permata Hijau</h5>
                </a>
                <a class="content-shadow" href="{{ route('notifications.detail', ['id' => 3]) }}">
                    <span class="block mb-2 text-xs font-semibold text-gray-600">12 Juni 2025</span>
                    <h5 class="!mb-0">Kantor Pos Jaya Baru - Srengseng Sawah</h5>
                </a>
            </div>
        </div>
    </div>
</x-dynamic-layout> --}}