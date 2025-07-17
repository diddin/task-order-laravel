@props(['networks'])

@php
    $prefix = Auth::user()->role->name; // Contoh: 'admin' atau 'master'
@endphp

<div>
    <a href="{{ route($prefix . '.networks.create') }}"
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
                        <td class="p-2">
                            {{ $loop->iteration + ($networks->currentPage() - 1) * $networks->perPage() }}
                        </td>
                        <td class="p-2">{{ $network->network_number }}</td>
                        <td class="p-2">{{ $network->detail }}</td>
                        <td class="p-2">{{ $network->customer->name ?? '-' }}</td>
                        <td class="p-2">
                            <a href="{{ route($prefix . '.networks.show', $network) }}" class="text-blue-500">Lihat</a> |
                            <a href="{{ route($prefix . '.networks.edit', $network) }}" class="text-yellow-500">Edit</a> |
                            <form action="{{ route($prefix . '.networks.destroy', $network) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure to delete this network?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">
                            Tidak ada daftar no jaringan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $networks->links() }}
        </div>
    </div>
</div>
