<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Jaringan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold mb-4">Informasi Jaringan</h3>

                <div class="mb-3">
                    <strong>No. Jaringan:</strong>
                    <p>{{ $network->network_number }}</p>
                </div>

                <div class="mb-3">
                    <strong>Detail:</strong>
                    <p>{{ $network->detail }}</p>
                </div>

                <div class="mb-3">
                    <strong>Pelanggan:</strong>
                    <p>{{ $network->customer->name ?? '-' }}</p>
                </div>

                <hr class="my-6 border-gray-600">

                <h4 class="text-md font-semibold mb-2">Relasi Tiket</h4>

                @if($network->tasks && $network->tasks->count())
                    <table class="w-full text-sm mb-4">
                        <thead>
                            <tr class="text-left border-b dark:border-gray-600">
                                <th class="p-2">Detail</th>
                                <th class="p-2">Assign</th>
                                <th class="p-2">Status</th>
                                <th class="p-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($network->tasks as $task)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="p-2">{{ $task->detail }}</td>
                                    <td class="p-2">{{ $task->assignedUser->name ?? '-' }}</td>
                                    <td class="p-2 capitalize">{{ $task->action }}</td>
                                    <td class="p-2">
                                        <a href="{{ route('master.tasks.show', $task) }}" class="text-blue-500">Lihat</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-400">Tidak ada tiket yang terkait dengan jaringan ini.</p>
                @endif

                <div class="mt-6">
                    <a href="{{ route('master.networks.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-layout>
