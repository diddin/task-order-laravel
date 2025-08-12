<x-dynamic-layout>
    <div class="body-content">  
        <div class="container space-y-6">
            <a href="{{ route('technician.dashboard') }}" 
                class="back-to inline-flex items-center mb-4 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                <span class="text-xl ri-arrow-left-s-line mr-1"></span>
                <span>Kembali</span>
            </a>

            <div class="flex flex-wrap items-center justify-between gap-2 sm:gap-4 px-5">
                <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Pemberitahuan</h4>
            </div>
            <div class="wrapper dark:bg-gray-800 rounded-lg p-4">
                @forelse ($notifications['announcements'] as $announcement)
                    <a href="{{ route('notifications.detail', ['id' => $announcement->id, 'type' => 'announcement']) }}" 
                        class="block mb-4 last:mb-0 hover:bg-gray-200 dark:hover:bg-gray-600 p-3 rounded-md transition">
                        <span class="block mb-2 text-xs font-semibold text-gray-600 dark:text-gray-400">
                            {{ $announcement->created_at->translatedFormat('d F Y') }}
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
        </div>
    </div>
</x-dynamic-layout>