<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Admin') }}
        </h2>
    </x-slot>
    
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('master.admins.create') }}"
               class="ml-1 mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
               + Tambah Admin
            </a>
            @if (session('status'))
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ session('status') }}</p>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                <table class="min-w-full text-sm">
                    <thead class="border-b dark:border-gray-700">
                        <tr>
                            <th class="text-left p-2">#</th>
                            <th class="text-left p-2">Nama</th>
                            <th class="text-left p-2">Email</th>
                            <th class="text-left p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr class="border-b dark:border-gray-700">
                                <td class="p-2">{{ $loop->iteration }}</td>
                                <td class="p-2">{{ $admin->name }}</td>
                                <td class="p-2">{{ $admin->email }}</td>
                                <td class="p-2">
                                    <a href="{{ route('master.admins.show', $admin) }}" class="text-blue-500">Lihat</a> |
                                    <a href="{{ route('master.admins.edit', $admin) }}" class="text-yellow-500">Edit</a> |
                                    <form action="{{ route('master.admins.destroy', $admin) }}" method="POST" class="inline"
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
                    {{ $admins->links() }}
                </div>
            </div>
        </div>
    </div>
</x-dynamic-layout>
