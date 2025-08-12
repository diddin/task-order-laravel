@props(['tasks'])

@php
    $prefix = Auth::user()->role->name; // Contoh: 'admin' atau 'master'
@endphp

<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-3">

        <x-link-add-button href="{{ route($prefix . '.tasks.create') }}" text="Tambah Tiket" prefix="+" />

        <form method="GET" action="{{ route($prefix . '.tasks.index') }}">
            <label for="action" class="text-sm text-gray-700 dark:text-gray-200 mr-2">Filter Status:</label>
            <select name="action" id="action" onchange="this.form.submit()"
                class="p-2 border w-48 rounded dark:bg-gray-700 dark:text-white">
                <option value="">Semua</option>
                <option value="null" {{ request('action') === 'null' ? 'selected' : '' }}>Belum Dikerjakan</option>
                <option value="in progress" {{ request('action') === 'in progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                <option value="completed" {{ request('action') === 'completed' ? 'selected' : '' }}>Selesai</option>
            </select>
        </form>
        
        <form method="GET" action="{{ route($prefix . '.tasks.index') }}">
            <label for="category" class="text-sm text-gray-700 dark:text-gray-200 mr-2">Kategori:</label>
            <select name="category" id="category" class="p-2 border rounded w-48" onchange="this.form.submit()">
                <option value="">-- Semua --</option>
                <option value="akses" {{ request('category') === 'akses' ? 'selected' : '' }}>Akses</option>
                <option value="backbone" {{ request('category') === 'backbone' ? 'selected' : '' }}>Backbone</option>
            </select>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
        @if(session('success'))
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="pt-10 text-sm text-gray-600 dark:text-gray-400"
            >{{ session('success') }}</p>
        @endif

        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-gray-400 dark:border-gray-700">
                    <th class="text-left p-2">#</th>
                    <th class="text-left p-2">Detail Tiket</th>
                    <th class="text-left p-2">Pelanggan</th>
                    <th class="text-left p-2">No. Jaringan</th>
                    <th class="text-left p-2">PIC</th>
                    <th class="text-left p-2">Status</th>
                    <th class="text-left p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition duration-100">
                        <td class="p-2">
                            {{ $loop->iteration + ($tasks->currentPage() - 1) * $tasks->perPage() }}
                        </td>
                        <td class="p-2">{{ $task->detail }}</td>
                        <td class="p-2">{{ $task->customer->name }}</td>
                        <td class="p-2">{{ $task->customer->network_number ?? '-' }}</td>
                        <td class="p-2">{{ $task->pic()?->name ?? '-' }}</td>
                        <td class="p-2 align-top">
                            <div class="max-w-xs break-words">
                                @if($task->action === 'in progress')
                                    @php
                                        $lastOrder = $task->orders->last();
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-sm text-yellow-800 bg-yellow-200">
                                            Sedang Dikerjakan
                                        </span>
                                    @if($lastOrder)
                                        <span class="text-sm text-gray-500">
                                            : {{ $lastOrder->status }}
                                        </span>
                                    @endif
                                @else
                                    @switch($task->action)
                                        @case(null)
                                            <span class="px-2 py-1 rounded-full text-sm text-gray-600 bg-gray-200">
                                                Belum Dimulai
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
                                @endif
                            </div>
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