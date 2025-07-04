<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Jaringan') }}
        </h2>
    </x-slot>

    <div class="flex-1 ml-64 p-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('admin.networks.create') }}"
               class="ml-1 mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
               + Tambah Jaringan
            </a>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                @if(session('success'))
                    <div class="mb-4 text-green-600">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="min-w-full text-sm">
                    <thead class="border-b dark:border-gray-700">
                        <tr>
                            <th class="text-left p-2">#</th>
                            <th class="text-left p-2">No. Jaringan</th>
                            <th class="text-left p-2">Detail</th>
                            <th class="text-left p-2">Pelanggan</th>
                            <th class="text-left p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($networks as $network)
                            <tr class="border-b dark:border-gray-700">
                                <td class="p-2">{{ $loop->iteration + ($networks->currentPage()-1)*$networks->perPage() }}</td>
                                <td class="p-2">{{ $network->network_number }}</td>
                                <td class="p-2">{{ $network->detail }}</td>
                                <td class="p-2">{{ $network->customer->name ?? '-' }}</td>
                                <td class="p-2">
                                    <a href="{{ route('admin.networks.show', $network) }}" class="text-blue-500">Lihat</a> |
                                    <a href="{{ route('admin.networks.edit', $network) }}" class="text-yellow-500">Edit</a> |
                                    <form action="{{ route('admin.networks.destroy', $network) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Are you sure to delete this network?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center">Tidak ada daftar no jaringan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $networks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-dynamic-layout>
