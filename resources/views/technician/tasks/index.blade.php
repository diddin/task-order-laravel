<x-dynamic-layout>
    <!-- content -->
    <div class="body-content">  
        <div class="container">
            <div class="wrapper">
                <a href="{{ route('technician.dashboard') }}" class="back-to">
                    <span class="text-xl ri-arrow-left-s-line"></span>
                    <span>Kembali</span>
                </a>
                <h3>Aktifitas Anda</h3>
                @foreach($tasks as $task)
                    <div class="content-shadow">
                        <p class="text-gray-600 font-medium italic">Pelanggan:</p>
                        <h5>{{ $task->network->customer->name }}</h5>
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
            </div>
        </div>
     </div>
</x-dynamic-layout>