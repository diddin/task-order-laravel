@props(['task'])

@php
    $prefix = Auth::user()->role->name; // Misal: 'admin' atau 'master'
@endphp

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
    <h3 class="text-lg font-semibold mb-4">Detail Informasi Tiket</h3>

    <div class="mb-3">
        <strong>Jaringan:</strong>
        <p>{{ $task->customer?->network_number ?? '-' }}</p>
    </div>

    <div class="mb-3">
        <strong>Nomor Tiket:</strong>
        <p>{{ $task->task_number ?? '-' }}</p>
    </div>

    <div class="mb-3">
        <strong>Pelanggan:</strong>
        <p>{{ $task->customer?->name ?? '-' }}</p>
    </div>

    <div class="mb-3">
        <strong>Kontak Person:</strong>
        <p>{{ $task->customer?->contact_person ?? '-' }}</p>
    </div>

    <div class="mb-3">
        <strong>PIC Pelanggan:</strong>
        <p>{{ $task->customer?->pic ?? '-' }}</p>
    </div>

    <div class="mb-3">
        <strong>Detail Tiket:</strong>
        <p>{{ $task->detail }}</p>
    </div>

    <div class="mb-3">
        <strong>Kategori:</strong>
        <p class="capitalize">{{ $task->category ?? '-' }}</p>
    </div>

    <div class="mb-3">
        <strong>Data Teknis:</strong>
        <textarea id="technical_data" name="technical_data" rows="10"
            class="mt-2 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-0 focus:border-gray-400"
            readonly>{{ $task->customer->technical_data }}</textarea>
    </div>

    <div class="mb-3">
        <strong>PIC Teknisi:</strong>
        <p>{{ $task->pic()?->name ?? '-' }}</p>
    </div>

    <div class="mb-3">
        <strong>Tim Onsite:</strong>
        @php $onsite = $task->onsiteTeam(); @endphp
        @if($onsite->isEmpty())
            <p>-</p>
        @else
            <ul>
                @foreach($onsite as $user)
                    <li>{{ $user->name }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="mb-3">
        <strong>Dibuat Oleh:</strong>
        <p>{{ $task->creator->name ?? '-' }}</p>
    </div>

    <div class="mb-3">
        <strong>Status Aksi:</strong>
        <p class="capitalize">
            @switch($task->action)
                @case(null)
                    Belum dikerjakan
                    @break
                @case('in progress')
                    Sedang Dikerjakan
                    @break
                @case('completed')
                    Selesai
                    @break
                @default
                    {{ $task->action }}
            @endswitch
        </p>
    </div>

    <div class="mt-6 flex gap-4">
        @if ($prefix !== 'technician')
            <a href="{{ route($prefix . '.tasks.edit', $task) }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Edit Tiket
            </a>
        @endif
        <a href="{{ route($prefix . '.tasks.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Kembali
        </a>
    </div>
</div>
