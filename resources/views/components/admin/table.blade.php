@props(['admins'])

@php
    $prefix = Auth::user()->role->name; // Contoh: 'admin' atau 'master'
@endphp

<div>
    <x-link-add-button href="{{ route($prefix . '.admins.create') }}" text="Tambah Admin" prefix="+" />

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
                @foreach ($admins as $admin)
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition duration-100">
                        <td class="p-2">{{ $loop->iteration }}</td>
                        <td class="p-2">{{ $admin->name }}</td>
                        <td class="p-2">{{ $admin->email }}</td>
                        <td class="p-2">
                            @if($admin->phone_number)
                                {{ $admin->phone_number }}
                            @endif
                        </td>
                        <td class="p-2">
                            <div class="flex flex-wrap gap-2 sm:flex-nowrap sm:space-x-0">
                                <x-link-show-button :href="route('master.admins.show', $admin)" />
                                <x-link-edit-button :href="route('master.admins.edit', $admin)" />
                                <x-link-delete-button :action="route('master.admins.destroy', $admin)" />
                            </div>
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