<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Tiket') }}
        </h2>
    </x-slot>

    <div class="flex-1 sm:ml-64 p-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 sm:rounded-lg shadow-sm">
                <x-task.form 
                    :task="$task" 
                    :networks="$networks" 
                    :users="$users" 
                    :pic="$pic" 
                    :onsiteTeam="$onsiteTeam" 
                />
            </div>
        </div>
        <hr class="my-6 border-gray-600">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h4 class="text-md font-semibold mb-2">Progress Timeline</h4>
            @if ($task->orders->count())
                <ul class="list-disc list-inside text-sm p-2">
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
