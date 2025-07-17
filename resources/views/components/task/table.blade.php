@props(['tasks'])

@php
    $prefix = Auth::user()->role->name; // Contoh: 'admin' atau 'master'
@endphp

<div>
    <a href="{{ route($prefix . '.tasks.create') }}"
       class="ml-1 mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
       + Tambah Tiket
    </a>

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
                    <th class="text-left p-2">Assign</th>
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
                        <td class="p-2">{{ $task->assignedUser->name ?? '-' }}</td>
                        <td class="p-2">{{ $task->action }}</td>
                        <td class="p-2">
                            <a href="{{ route($prefix . '.tasks.show', $task) }}" class="text-blue-500">Lihat</a> |
                            <a href="{{ route($prefix . '.tasks.edit', $task) }}" class="text-yellow-500">Edit</a> |
                            <form action="{{ route($prefix . '.tasks.destroy', $task) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Hapus tiket ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Hapus</button>
                            </form>
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