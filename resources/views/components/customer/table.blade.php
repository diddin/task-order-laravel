@props(['customers'])

@php
    $prefix = Auth::user()->role->name; // Contoh: 'admin' atau 'master'
@endphp

<div>
    <a href="{{ route($prefix . '.customers.create') }}"
       class="ml-1 mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
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
                @forelse ($customers as $customer)
                    <tr class="border-b dark:border-gray-700">
                        <td class="p-2">
                            {{ $loop->iteration }}
                        </td>
                        <td class="p-2">{{ $customer->name }}</td>
                        <td class="p-2">{{ $customer->address }}</td>
                        <td class="p-2">
                            <a href="{{ route($prefix . '.customers.show', $customer) }}" class="text-blue-500">Lihat</a> |
                            <a href="{{ route($prefix . '.customers.edit', $customer) }}" class="text-yellow-500">Edit</a> |
                            <form action="{{ route($prefix . '.customers.destroy', $customer) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">Tidak ada pelanggan ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    </div>
</div>