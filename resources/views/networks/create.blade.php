<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Jaringan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('networks.store') }}" method="POST">
                    @csrf
                    @include('networks._form', ['network' => new \App\Models\Network, 'customers' => $customers])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
