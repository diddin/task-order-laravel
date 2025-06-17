<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('customers.create') }}"
               class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
               + Tambah Pelanggan
            </a>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                <table class="min-w-full text-sm">
                    <thead class="border-b dark:border-gray-700">
                        <tr>
                            <th class="text-left p-2">#</th>
                            <th class="text-left p-2">Nama</th>
                            <th class="text-left p-2">Alamat</th>
                            <th class="text-left p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr class="border-b dark:border-gray-700">
                                <td class="p-2">{{ $loop->iteration }}</td>
                                <td class="p-2">{{ $customer->name }}</td>
                                <td class="p-2">{{ $customer->address }}</td>
                                <td class="p-2">
                                    <a href="{{ route('customers.show', $customer) }}" class="text-blue-500">Lihat</a> |
                                    <a href="{{ route('customers.edit', $customer) }}" class="text-yellow-500">Edit</a> |
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
