<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Tiket') }}
        </h2>
    </x-slot>

    <div class="flex-1 ml-64 p-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('admin.tasks.create') }}" class="ml-1 mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
                + Tambah tiket
            </a>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                @if (session('success'))
                    <div class="mb-4 text-green-500">{{ session('success') }}</div>
                @endif

                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b dark:border-gray-700">
                            <th class="p-2">#</th>
                            <th class="p-2">Detail Tiket</th>
                            <th class="p-2">No. Jaringan</th>
                            <th class="p-2">Assign</th>
                            <th class="p-2">Status</th>
                            <th class="p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr class="border-b dark:border-gray-700">
                                <td class="p-2">{{ $loop->iteration + ($tasks->currentPage()-1)*$tasks->perPage() }}</td>
                                <td class="p-2">{{ $task->detail }}</td>
                                <td class="p-2">{{ $task->network->network_number ?? '-' }}</td>
                                <td class="p-2">{{ $task->assignedUser->name ?? '-' }}</td>
                                <td class="p-2">{{ $task->action }}</td>
                                <td class="p-2">
                                    <a href="{{ route('admin.tasks.show', $task) }}" class="text-blue-500">Lihat</a> |
                                    <a href="{{ route('admin.tasks.edit', $task) }}" class="text-yellow-500">Edit</a> |
                                    <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Delete this task?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-4 text-center">No tasks available.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-dynamic-layout>
