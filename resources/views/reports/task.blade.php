<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Tiket') }}
        </h2>
    </x-slot>
    <div class="flex-1 sm:ml-64 p-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-between mb-6 gap-4">
                {{-- Kiri: Filter Tanggal --}}
                <form method="GET" action="{{ route('task.report') }}" class="flex gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" class="p-2 border rounded">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" class="p-2 border rounded">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded">Tampilkan</button>
                    </div>
                </form>

                {{-- Kanan: Export --}}
                <div class="flex items-end gap-2">
                    <a href="{{ route('task.report.export', array_merge(request()->all(), ['format' => 'excel'])) }}" 
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Download Excel
                    </a>

                    <a href="{{ route('task.report.export', array_merge(request()->all(), ['format' => 'pdf'])) }}" 
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" target="_blank">
                    Download PDF
                    </a>
                </div>
            </div>

            {{-- Info Jumlah --}}
            <div class="mb-4">
                <strong>Total Tiket: </strong> {{ $tasks->count() }}
            </div>

            {{-- Tabel Tiket --}}
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">
                    <thead>
                        <tr class="bg-gray-300 dark:bg-gray-700">
                            <th class="p-2 border">No</th>
                            <th class="p-2 border">Cluster</th>
                            <th class="p-2 border">Categori</th>
                            <th class="p-2 border">Bulan</th>
                            <th class="p-2 border">Case ID</th>
                            <th class="p-2 border">Nojar</th>
                            <th class="p-2 border">Pelanggan</th>
                            <th class="p-2 border">Tanggal Aduan</th>
                            <th class="p-2 border">Durasi</th>
                            <th class="p-2 border">Case Gangguan</th>
                            <th class="p-2 border">Status</th>
                            {{-- <th class="p-2 border">Dibuat Oleh</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $index => $task)
                            <tr>
                                <td class="p-2 border">{{ $index + 1 }}</td>
                                <td class="p-2 border">{{ $task->customer->cluster }}</td>
                                <td class="p-2 border">{{ $task->category }}</td>
                                <td class="p-2 border">{{ \Carbon\Carbon::parse($task->created_at)->translatedFormat('F') }}</td>
                                <td class="p-2 border">{{ $task->task_number }}</td>
                                <td class="p-2 border">{{ $task->customer->network_number }}</td>
                                <td class="p-2 border">{{ $task->customer?->name ?? '-' }}</td>
                                <td class="p-2 border">{{ \Carbon\Carbon::parse($task->created_at)->translatedFormat('d F') }}</td>
                                <td class="p-2 border">{{ $task->duration ?? '-' }}</td>
                                <td class="p-2 border">{{ $task->detail ?? '-' }}</td>
                                <td class="p-2 border capitalize">
                                    {{-- {{ $task->action ?? '-' }} --}}
                                    @switch($task->action)
                                        @case(null)
                                                Belum Dimulai
                                            @break

                                        @case('completed')
                                                Selesai
                                            @break

                                        @default
                                                {{ $task->action }}
                                    @endswitch
                                </td>
                                {{-- <td class="p-2 border">{{ $task->creator?->name ?? '-' }}</td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-2 text-center border">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded text-gray-900 dark:text-gray-100">
                    <strong>Failure Rate (FR):</strong> {{ $fr }}%
                </div>
                <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded text-gray-900 dark:text-gray-100">
                    <strong>Service Level Agreement (SLA):</strong> {{ $sla }}%
                </div>
                <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded text-gray-900 dark:text-gray-100">
                    <strong>Mean Time to Repair (MTTR):</strong> {{ $mttr }}%
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const startInput = document.getElementById('start_date');
    const endInput = document.getElementById('end_date');

    function getMonthRange(dateStr) {
        const date = new Date(dateStr);
        const year = date.getFullYear();
        const month = date.getMonth();

        const start = new Date(year, month, 1).toISOString().split('T')[0];
        const end = new Date(year, month + 1, 0).toISOString().split('T')[0];
        return { start, end };
    }

    function updateEndRange() {
        if (startInput.value) {
            const { start, end } = getMonthRange(startInput.value);
            endInput.setAttribute('min', start);
            endInput.setAttribute('max', end);

            if (endInput.value && (endInput.value < start || endInput.value > end)) {
                endInput.value = '';
            }
        } else {
            endInput.removeAttribute('min');
            endInput.removeAttribute('max');
        }
    }

    startInput.addEventListener('change', function () {
        updateEndRange();
    });

    // Jalankan saat halaman dimuat
    updateEndRange();

    // function updateStartRange() {
    //     if (endInput.value) {
    //         const { start, end } = getMonthRange(endInput.value);
    //         startInput.setAttribute('min', start);
    //         startInput.setAttribute('max', end);

    //         if (startInput.value && (startInput.value < start || startInput.value > end)) {
    //             startInput.value = '';
    //         }
    //     } else {
    //         startInput.removeAttribute('min');
    //         startInput.removeAttribute('max');
    //     }
    // }

    // endInput.addEventListener('change', function () {
    //     updateStartRange();
    // });

    
    //updateStartRange();
});
</script>
@endpush
</x-dynamic-layout>