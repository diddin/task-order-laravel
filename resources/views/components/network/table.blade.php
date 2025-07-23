@props(['networks'])

@php
    $prefix = Auth::user()->role->name; // Contoh: 'admin' atau 'master'
@endphp

<div>
    <x-link-add-button href="{{ route($prefix . '.networks.create') }}" text="Tambah Jaringan" prefix="+" />

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
                            <div class="flex flex-wrap gap-2 sm:flex-nowrap sm:space-x-1">
                                <x-link-show-button :href="route($prefix . '.networks.show', $network)" />
                                <x-link-edit-button :href="route($prefix . '.networks.edit', $network)" />
                                <x-link-delete-button :action="route($prefix . '.networks.destroy', $network)" />
                            </div>
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
