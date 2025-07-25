<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Tiket') }}
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
    </div>
</x-dynamic-layout>
