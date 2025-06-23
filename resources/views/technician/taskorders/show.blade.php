<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Task Order Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Status:</h3>
                    <p>{{ $taskOrder->status }}</p>

                    <h3 class="text-lg font-bold mt-4">Tiket:</h3>
                    <p>{{ $taskOrder->task->detail ?? '-' }}</p>

                    <p class="text-sm mt-4 text-gray-500">
                        Dibuat pada: {{ $taskOrder->created_at ? $taskOrder->created_at->format('d M Y H:i') : '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
