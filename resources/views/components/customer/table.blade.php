@props(['customers'])

@php
    $prefix = Auth::user()->role->name; // Contoh: 'admin' atau 'master'
@endphp

<div>
    <x-link-add-button href="{{ route($prefix . '.customers.create') }}" text="Tambah Pelanggan" prefix="+" />

    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
        @if(session('success'))
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="pt-10 text-sm text-gray-600 dark:text-gray-400"
            >{{ session('success') }}</p>
        @endif
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-gray-400 dark:border-gray-700">
                    <th class="text-left p-2">#</th>
                    <th class="text-left p-2">Nama</th>
                    <th class="text-left p-2">Alamat</th>
                    <th class="text-left p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition duration-100">
                        <td class="p-2">
                            {{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}
                        </td>
                        <td class="p-2">{{ $customer->name }}</td>
                        <td class="p-2">{{ $customer->address }}</td>
                        <td class="p-2">
                            <div class="flex flex-wrap gap-2 sm:flex-nowrap sm:space-x-0">
                                <x-link-show-button :href="route($prefix . '.customers.show', $customer)" />
                                <x-link-edit-button :href="route($prefix . '.customers.edit', $customer)" />
                                <x-link-delete-button :action="route($prefix . '.customers.destroy', $customer)" />
                            </div>
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