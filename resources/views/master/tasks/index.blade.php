<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Tiket') }}
        </h2>
    </x-slot>

    <div class="flex-1 sm:ml-64 p-4">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <x-task.table :tasks="$tasks" />
        </div>
    </div>
</x-dynamic-layout>
