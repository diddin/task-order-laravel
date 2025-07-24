@props(['announcements'])

@php
    $prefix = Auth::user()->role->name; // Contoh: 'admin' atau 'master'
@endphp

<div>
    <x-link-add-button href="{{ route($prefix . '.announcements.create') }}" text="Tambah Pengumuman" prefix="+" />

    @if (session('status'))
        <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-gray-600 dark:text-gray-400"
        >{{ session('status') }}</p>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
        <table class="min-w-full text-sm">
            <thead class="border-b dark:border-gray-700">
                <tr>
                    <th class="text-left p-2">#</th>
                    <th class="text-left p-2">Judul</th>
                    <th class="text-left p-2">Isi</th>
                    <th class="text-left p-2">Aktif</th>
                    <th class="text-left p-2">Tanggal Mulai</th>
                    <th class="text-left p-2">Tanggal Selesai</th>
                    <th class="text-left p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($announcements as $announcement)
                    <tr class="border-b dark:border-gray-700">
                        <td class="p-2">{{ ($announcements->currentPage() - 1) * $announcements->perPage() + $loop->iteration }}</td>
                        <td class="p-2">{{ $announcement->title }}</td>
                        <td class="p-2">{{ Str::limit($announcement->content, 50) }}</td>
                        <td class="p-2">
                            @if ($announcement->is_active)
                                <span class="text-green-600 font-semibold">Ya</span>
                            @else
                                <span class="text-red-600 font-semibold">Tidak</span>
                            @endif
                        </td>
                        <td class="p-2">{{ $announcement->start_date?->format('d M Y') ?? '-' }}</td>
                        <td class="p-2">{{ $announcement->end_date?->format('d M Y') ?? '-' }}</td>
                        <td class="p-2">
                            <div class="flex flex-wrap gap-2 sm:flex-nowrap sm:space-x-0">
                                <x-link-show-button :href="route($prefix . '.announcements.show', $announcement)" />
                                <x-link-edit-button :href="route($prefix . '.announcements.edit', $announcement)" />
                                <x-link-delete-button :action="route($prefix . '.announcements.destroy', $announcement)" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $announcements->links() }}
        </div>
    </div>
</div>