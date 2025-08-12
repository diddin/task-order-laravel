@props(['customer'])

@php
    $prefix = Auth::user()->role->name; // Contoh: 'admin' atau 'master'
@endphp

<div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

    <div class="mb-3">
        <strong>Kategori:</strong>
        <p>{{ $customer->category }}</p>
    </div>
    <hr class="my-2 w-1/2 border-gray-200 dark:border-gray-700">
    <div class="mb-3">
        <strong>Akses/Cluster:</strong>
        <p>{{ $customer->cluster ?? "-" }}</p>
    </div>
    <hr class="my-2 w-1/2 border-gray-200 dark:border-gray-700">
    <div class="mb-3">
        <strong>No. Jaringan:</strong>
        <p>{{ $customer->network_number ?? "-" }}</p>
    </div>
    <hr class="my-2 w-1/2 border-gray-200 dark:border-gray-700">
    <div class="mb-3">
        <strong>Nama:</strong>
        <p>{{ $customer->name }}</p>
    </div>
    <hr class="my-2 w-1/2 border-gray-200 dark:border-gray-700">
    <div class="mb-3">
        <strong>Kontak Person:</strong>
        <p>{{ $customer->contact_person }}</p>
    </div>
    <hr class="my-2 w-1/2 border-gray-200 dark:border-gray-700">
    <div class="mb-3">
        <strong>Kontak PIC:</strong>
        <p>{{ $customer->pic }}</p>
    </div>
    <hr class="my-2 w-1/2 border-gray-200 dark:border-gray-700">
    <div class="mb-3">
        <strong>Data Teknis:</strong>
        <textarea id="technical_data" name="technical_data" rows="10"
                class="mt-2 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-0 focus:border-gray-400"
                readonly>{{ $customer->technical_data }}</textarea>
    </div>
    <div class="mb-3">
        <strong>Alamat:</strong>
        <p>{{ $customer->address }}</p>
    </div>

    {{-- Jika kamu punya halaman detail customer --}}
    {{-- <a href="{{ route($prefix . '.customers.show', $customer) }}" class="text-blue-500">Lihat Detail Pelanggan</a> --}}
    
    <hr class="my-6 border-gray-600">

    <h4 class="text-md font-semibold mb-2">Daftar Tiket</h4>

    @if($customer->tasks && $customer->tasks->count())
        <ul class="list-disc list-inside">
            @foreach($customer->tasks as $task)
                <li>
                    <a href="{{ route($prefix . '.tasks.show', $task) }}" class="text-blue-500 hover:underline">
                        {{ $task->detail }} 
                    </a> - 
                    <span class="italic text-gray-600">
                        @switch($task->action)
                            @case('in progress')
                                Sedang Dikerjakan
                                @break
                            @case('completed')
                                Selesai
                                @break
                            @default
                                Belum dikerjakan
                        @endswitch
                    </span>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-400">Belum ada tiket terkait untuk jaringan ini.</p>
    @endif

    <div class="mt-6">
        <a href="{{ route($prefix . '.customers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Kembali
        </a>
    </div>
</div>