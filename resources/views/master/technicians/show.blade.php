<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Teknisi') }}
        </h2>
    </x-slot>

    {{-- <div class="py-6"> --}}
    <div class="flex-1 ml-64 p-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold mb-4">Informasi Teknisi</h3>
                <div class="mb-3">
                    <strong>Nama:</strong>
                    <p>{{ $technician->name }}</p>
                </div>
                <div class="mb-3">
                    <strong>Email:</strong>
                    <p>{{ $technician->email }}</p>
                </div>

                <hr class="my-6 border-gray-600">

                <div class="mt-6">
                    <a href="{{ route('master.technicians.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-layout>
