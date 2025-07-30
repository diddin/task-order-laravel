@props(['task'])

@php
    $prefix = Auth::user()->role->name; // Misal: 'admin' atau 'master'
@endphp

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
    <h3 class="text-lg font-semibold mb-4">Detail Informasi Tiket</h3>

    <div class="mb-3">
        <strong>Detail Tiket:</strong>
        <p>{{ $task->detail }}</p>
    </div>

    <div class="mb-3">
        <strong>No. Jaringan:</strong>
        <p>{{ $task->network->network_number ?? '-' }}</p>
    </div>

    {{-- <div class="mb-3">
        <strong>Assigned Teknisi:</strong>
        <ul>
            @foreach($task->assignedUsers as $user)
                <li>{{ $user->name }} ({{ ucfirst($user->pivot->role_in_task) }})</li>
            @endforeach
        </ul>
    </div> --}}

    <div class="mb-3">
        <strong>PIC:</strong>
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
