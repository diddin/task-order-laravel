@php
    $role = $task->creator->role->name;
    $routeName = $role . '.tasks.show';
@endphp

@component('mail::message')
# Halo {{ $task->creator->name ?? 'N/A' }}

Anda telah membuat tiket berikut:

### Detail Tugas:
- **Judul / Rincian**: {{ $task->detail }}
{{-- - **Status**: {{ ucfirst($task->action ?? 'Belum ditentukan') }} --}}
- **Jaringan**: {{ $task->network->network_number }}
- **Pelanggan**: {{ $task->network->customer->name }}
- **Lokasi**: {{ $task->network->customer->address }}

- **Dibuat oleh**: {{ $task->creator->name ?? 'N/A' }}

@component('mail::button', ['url' => route($routeName, ['task' => $task->id])])
Lihat Tiket
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent