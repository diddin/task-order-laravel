@component('mail::message')
# Halo {{ $user->name }}

Anda telah ditugaskan dalam tiket berikut:

### Detail Tugas:
- **Kategori**: {{ ucfirst($task->category ?? '-') }}
- **Judul / Rincian**: {{ $task->detail }}
{{-- - **Status**: {{ ucfirst($task->action ?? 'Belum ditentukan') }} --}}
- **Jaringan**: {{ $task->customer->network_number ?? '-' }}
- **Pelanggan**: {{ $task->customer->name ?? '-' }}
- **Lokasi**: {{ $task->customer->address ?? '-' }}
- **Peran Anda**: {{ ucfirst($user->pivot->role_in_task) }} Teknisi
- **Dibuat oleh**: {{ $task->creator->name ?? 'N/A' }}

@component('mail::button', ['url' => url('/taskorders/' . $task->id)])
Lihat Tiket
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
