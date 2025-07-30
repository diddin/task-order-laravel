<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container">
        <div class="wrapper">
            <h3>Tiket baru untuk anda</h3>
            @foreach ($tasks['newTasks'] as $task)
                <a href="{{ route('technician.taskorders.progress', $task ) }}" class="content-shadow hover:bg-gray-100">
                    <h2>{{ $task->network->customer->name }}</h2>
                    <div class="icon-text">
                        <span class="ri-map-pin-line"></span>
                        <p>
                            {{ $task->network->customer->address }}
                        </p>
                    </div>
                    <div class="icon-text">
                        <span class="ri-corner-right-up-line"></span>
                        <p>Akses: FO B2B to Curug</p>
                    </div>
                    <div class="eta-footer group-between">
                        <span class="text-gray-700">
                            <span class="ri-calendar-line"></span>
                            {{ $task->created_at->translatedFormat('d F Y') }}
                        </span>
                        <span class="text-red-700">
                            <span class="ri-time-line"></span>
                            {{ $task->remaining }}
                        </span>
                    </div>
                </a>
            @endforeach
            {{-- <a href="detail_tiket.html" class="content-shadow">
                <h2>Bank Mandiri TASPEN POS - KCP Balaraja</h2>
                <div class="icon-text">
                    <span class="ri-map-pin-line"></span>
                    <p>Jl. Raya Serang km.25,5, Kel Cibadak, Kec. Cikupa, Kab. Tangerang - KCP Balaraja, Tangerang</p>
                </div>
                <div class="icon-text">
                    <span class="ri-corner-right-up-line"></span>
                    <p>Akses: FO B2B to Curug</p>
                </div>
                <div class="eta-footer group-between">
                    <span class="text-gray-700">ETA: 12:00</span>
                    <span class="text-red-700">5 jam 14 menit tersisa</span>
                </div>
            </a>
            <a href="detail_tiket.html" class="content-shadow">
                <h2>Kantor Pos Jaya Baru - Srengseng Sawah</h2>
                <div class="icon-text">
                    <span class="ri-map-pin-line"></span>
                    <p>Jl. Raya Srengseng km.15,5, Kel Cibadak, Kec. Cikupa, Kab. Tangerang - KCP Balaraja, Tangerang</p>
                </div>
                <div class="icon-text">
                    <span class="ri-corner-right-up-line"></span>
                    <p>Akses: FO B2B to Curug</p>
                </div>
                <div class="eta-footer group-between">
                    <span class="text-gray-700">ETA: 12:00</span>
                    <span class="text-red-700">4 jam 14 menit tersisa</span>
                </div>
            </a> --}}
        </div>
        <div class="wrapper">
            <div class="mb-2 group-between">
                <h3>Aktifitas Anda</h3>
                <a href="{{ route('technician.tasks.index') }}" 
                    class="flex items-center gap-2 text-blue-700 hover:text-blue-900 transition-all duration-200 group">
                    <span class="text-xs">Lihat Semua</span>
                    <span class="ri-arrow-right-long-fill transform transition-transform duration-200 group-hover:translate-x-1"></span>
                </a>
            </div>
            @foreach($tasks['myActivities'] as $task)
                <div class="content-shadow">
                    <h5>
                        {{-- <span class="ri-map-pin-line"></span> --}}
                        {{ $task->network->customer->name }}
                    </h5>
                    <div class="group-between">
                        <span class="text-gray-700">
                            <span class="ri-calendar-line"></span>
                            {{ $task->created_at->translatedFormat('d F Y') }}
                        </span>
                        @if($task->action === 'completed')
                            <span class="text-green-700">
                                <span class="ri-check-line"></span>
                                Selesai
                            </span>
                        @elseif($task->action === 'in progress')
                            <span class="text-yellow-700">
                                <span class="ri-time-line"></span>
                                Dalam Proses
                            </span>
                        @else
                            <span class="text-red-700">
                                <span class="ri-close-line"></span>
                                Tidak Tercapai
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
            {{-- <div class="content-shadow">
                <h5>Kantor Pos Jaya Baru - Srengseng Sawah</h5>
                <div class="group-between">
                    <span class="text-gray-700">12 Juni 2025</span>
                    <span class="text-green-700">Selesai</span>
                </div>
            </div>
            <div class="content-shadow">
                <h5>Bank BRI Permata Hijau</h5>
                <div class="group-between">
                    <span class="text-gray-700">12 Juni 2025</span>
                    <span class="text-red-700">Tidak Tercapai</span>
                </div>
            </div>
            <div class="content-shadow">
                <h5>Kantor Pos Jaya Baru - Srengseng Sawah</h5>
                <div class="group-between">
                    <span class="text-gray-700">12 Juni 2025</span>
                    <span class="text-green-700">Selesai</span>
                </div>
            </div> --}}
        </div>
    </div>
</x-dynamic-layout>