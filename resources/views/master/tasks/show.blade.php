<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Tiket') }}
        </h2>
    </x-slot>

    {{-- <div class="py-6"> --}}
    <div class="flex-1 ml-64 p-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold mb-4">Detail Informasi Tiket</h3>

                <div class="mb-3">
                    <strong>Detail Tiket:</strong>
                    <p>{{ $task->detail }}</p>
                </div>

                <div class="mb-3">
                    <strong>No. Jaringan:</strong>
                    <p>{{ $task->network->network_number ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Assign:</strong>
                    <p>{{ $task->assignedUser->name ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Dibuat Oleh:</strong>
                    <p>{{ $task->creator->name ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Status Aksi:</strong>
                    <p class="capitalize">{{ $task->action }}</p>
                </div>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('master.tasks.edit', $task) }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Edit Tiket
                    </a>
                    <a href="{{ route('master.tasks.index') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <hr class="my-6 border-gray-600">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h4 class="text-md font-semibold mb-2">Progress Timeline</h4>
            @if ($task->orders->count())
                <ul class="list-disc list-inside text-sm">
                    @foreach ($task->orders as $order)
                        <li>
                            <span class="text-gray-600 italic">{{ $order->created_at->format('d M Y H:i') }}:</span>
                            <span class="text-gray-800">{{ $order->status }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
            <p class="text-sm text-gray-400">Belum ada progress tersedia.</p>
            @endif
        </div>
    </div>
</x-dynamic-layout>
