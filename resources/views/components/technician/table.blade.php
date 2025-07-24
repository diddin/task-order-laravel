@props(['technicians'])

@php
    $prefix = Auth::user()->role->name; // Contoh: 'admin' atau 'master'
@endphp

<x-link-add-button href="{{ route($prefix . '.technicians.create') }}" text="Tambah Teknisi" prefix="+" />

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
        <thead>
            <tr class="border-b border-gray-400 dark:border-gray-700">
                <th class="text-left p-2">#</th>
                <th class="text-left p-2">Nama</th>
                <th class="text-left p-2">Email</th>
                <th class="text-left p-2">No. Hp</th>
                <th class="text-left p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($technicians as $technician)
            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition duration-100">
                    <td class="p-2">
                        {{ ($technicians->currentPage() - 1) * $technicians->perPage() + $loop->iteration }}
                    </td>
                    <td class="p-2">{{ $technician->name }}</td>
                    <td class="p-2">{{ $technician->email }}</td>
                    <td class="p-2">
                        @if($technician->phone_number)
                            {{ $technician->phone_number }}
                        @endif
                    </td>
                    <td class="p-2">
                        <div class="flex flex-wrap gap-2 sm:flex-nowrap sm:space-x-0">
                            <x-link-show-button :href="route($prefix . '.technicians.show', $technician)" />
                            <x-link-edit-button :href="route($prefix . '.technicians.edit', $technician)" />
                            <x-link-delete-button :action="route($prefix . '.technicians.destroy', $technician)" />
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $technicians->links() }}
    </div>
</div>