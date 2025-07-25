@props(['customer'])

@php
    $prefix = Auth::user()->role->name; // Contoh: 'admin' atau 'master'
@endphp

<div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
    
    {{-- Customer Info --}}
    <h3 class="text-lg font-semibold mb-4">Informasi Pelanggan</h3>
    <div class="mb-3">
        <strong>Nama:</strong>
        <p>{{ $customer->name }}</p>
    </div>
    <div class="mb-3">
        <strong>Alamat:</strong>
        <p>{{ $customer->address }}</p>
    </div>

    <hr class="my-6 border-gray-600">

    {{-- Networks List --}}
    <h4 class="text-md font-semibold mb-2">Daftar Jaringan</h4>
    @if($customer->networks && $customer->networks->count())
        @foreach($customer->networks as $network)
            <div class="mb-6 border border-gray-600 rounded p-4">
                <div class="mb-2">
                    <strong>No. Jaringan:</strong> {{ $network->network_number }}<br>
                    <strong>Detail:</strong> {{ $network->detail }}
                </div>
                <a href="{{ route($prefix . '.networks.show', $network) }}" class="text-blue-500">Lihat</a>

                {{-- Tasks (Optional) --}}
                @if($network->tasks && $network->tasks->count())
                    <div class="mt-4">
                        <h5 class="font-semibold">Riwayat Perbaikan:</h5>
                        <ul class="list-disc list-inside text-sm">
                            @foreach($network->tasks as $task)
                                <li>
                                    <a href="{{ route($prefix . '.tasks.show', $task) }}" class="text-blue-400 hover:underline">
                                        {{ $task->detail }}
                                    </a> —
                                    <span class="italic text-gray-400">
                                        @if ($task->action === 'in progress')
                                            sedang dikerjakan
                                        @elseif ($task->action === 'completed')
                                            selesai
                                        @else
                                            belum dikerjakan
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="text-sm text-gray-400 mt-2">Belum pernah ada riwayat tugas perbaikan pada jaringan ini.</p>
                @endif
            </div>
        @endforeach
    @else
        <p class="text-gray-400">Pelanggan ini belum terdaftar pada salah satu no jaringan.</p>
    @endif

    <div class="mt-6">
        <a href="{{ route($prefix . '.customers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Kembali
        </a>
    </div>
</div>