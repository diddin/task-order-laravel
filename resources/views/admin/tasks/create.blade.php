<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Tiket') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 sm:rounded-lg shadow-sm">
                <form action="{{ route('admin.tasks.store') }}" method="POST">
                    @csrf
                    @include(Auth::user()->role->name.'.tasks._form', ['task' => new \App\Models\Task])
                </form>
            </div>
        </div>
    </div>
</x-dynamic-layout>
