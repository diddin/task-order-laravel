@props(['network'])

@php
    $prefix = Auth::user()->role->name; // Contoh: 'admin' atau 'master'
@endphp

{{-- <a href="{{ route('assets.show', $network->asset) }}" class="btn-secondary">Lihat Data Aset</a> --}}

<div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
    <h3 class="text-lg font-semibold mb-4">Informasi Jaringan</h3>

    <div class="mb-3">
        <strong class="block text-gray-700 dark:text-gray-200">No. Jaringan:</strong>
        <p class="text-gray-900 dark:text-gray-100">{{ $network->network_number }}</p>
    </div>
    
    <div class="mb-3">
        <strong class="block text-gray-700 dark:text-gray-200">Detail:</strong>
        <p class="text-gray-900 dark:text-gray-100">{{ $network->detail ?? '-' }}</p>
    </div>
    
    <div class="mb-3">
        <strong class="block text-gray-700 dark:text-gray-200">Akses:</strong>
        <p class="text-gray-900 dark:text-gray-100">{{ $network->access ?? '-' }}</p>
    </div>
    
    <div class="mb-3">
        <strong class="block text-gray-700 dark:text-gray-200">Data Core:</strong>
        <p class="text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $network->data_core ?? '-' }}</p>
    </div>
    
    <div class="mb-3">
        <strong class="block text-gray-700 dark:text-gray-200">Pelanggan:</strong>
        <p class="text-gray-900 dark:text-gray-100">{{ $network->customer->name ?? '-' }}</p>
    </div>

    <a href="{{ $network->asset 
        ? route('assets.edit', $network->asset) 
        : route('assets.create', ['network' => $network->id]) 
    }}" class="btn-secondary">
        {{ $network->asset ? 'Lihat Data Aset' : 'Tambah Data Aset' }}
    </a>

    {{-- <a href="{{ route('assets.edit', $network->asset) }}" class="btn-secondary">Lihat Data Aset</a> --}}

    <hr class="my-6 border-gray-600">

    <h4 class="text-md font-semibold mb-2">Relasi Tiket</h4>

    @if($network->tasks && $network->tasks->count())
        <table class="w-full text-sm mb-4">
            <thead>
                <tr class="text-left border-b dark:border-gray-600">
                    <th class="p-2">Detail</th>
                    <th class="p-2">PIC</th>
                    <th class="p-2">Onsite</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($network->tasks as $task)
                    <tr class="border-b dark:border-gray-700">
                        <td class="p-2">{{ $task->detail }}</td>
                        <td class="p-2">
                            {{ $task->pic()?->name ?? '-' }}
                        </td>
                        <td class="p-2">
                            @forelse ($task->onsiteTeam() as $member)
                                <span class="inline-block">{{ $member->name }}</span>@if (!$loop->last), @endif
                            @empty
                                -
                            @endforelse
                        </td>
                        <td class="p-2 capitalize">{{ $task->action ?? '-' }}</td>
                        <td class="p-2">
                            <a href="{{ route($prefix . '.tasks.show', $task->id) }}" class="text-blue-500 hover:underline">Lihat</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-400">Tidak ada tiket yang terkait dengan jaringan ini.</p>
    @endif

    <div class="mt-6">
        <a href="{{ route($prefix . '.networks.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Kembali
        </a>
    </div>
</div>