@props(['tasks'])

@php
    $prefix = Auth::user()->role->name; // Contoh: 'admin' atau 'master'
@endphp

<div>
    <x-link-add-button href="{{ route($prefix . '.tasks.create') }}" text="Tambah Tiket" prefix="+" />

    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
        @if(session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full text-sm">
            <thead class="border-b dark:border-gray-700">
                <tr>
                    <th class="text-left p-2">#</th>
                    <th class="text-left p-2">Detail Tiket</th>
                    <th class="text-left p-2">No. Jaringan</th>
                    <th class="text-left p-2">PIC</th>
                    <th class="text-left p-2">Status</th>
                    <th class="text-left p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                    <tr class="border-b dark:border-gray-700">
                        <td class="p-2">
                            {{ $loop->iteration + ($tasks->currentPage() - 1) * $tasks->perPage() }}
                        </td>
                        <td class="p-2">{{ $task->detail }}</td>
                        <td class="p-2">{{ $task->network->network_number ?? '-' }}</td>
                        <td class="p-2">{{ $task->pic()?->name ?? '-' }}</td>
                        <td class="p-2">
                            @switch($task->action)
                                @case(null)
                                    <span class="px-2 py-1 rounded-full text-sm text-gray-600 bg-gray-200">
                                        Belum Dimulai
                                    </span>
                                    @break

                                @case('in progress')
                                    <span class="px-2 py-1 rounded-full text-sm text-yellow-800 bg-yellow-200">
                                        Sedang Dikerjakan
                                    </span>
                                    @break

                                @case('completed')
                                    <span class="px-2 py-1 rounded-full text-sm text-green-800 bg-green-200">
                                        Selesai
                                    </span>
                                    @break

                                @default
                                    <span class="px-2 py-1 rounded-full text-sm text-gray-800 bg-gray-100">
                                        {{ $task->action }}
                                    </span>
                            @endswitch
                        </td>
                        <td class="p-2">
                            <div class="flex flex-wrap gap-2 sm:flex-nowrap sm:space-x-1">
                                <x-link-show-button :href="route($prefix . '.tasks.show', $task)" />
                                <x-link-edit-button :href="route($prefix . '.tasks.edit', $task)" />
                                <x-link-delete-button :action="route($prefix . '.tasks.destroy', $task)" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">
                            Tidak ada data tiket.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    </div>
</div>