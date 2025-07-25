@component('mail::message')
# Halo {{ $user->name }}

Anda telah ditugaskan dalam tiket berikut:

### Detail Tugas:
- **Judul / Rincian**: {{ $task->detail }}
{{-- - **Status**: {{ ucfirst($task->action ?? 'Belum ditentukan') }} --}}
- **Jaringan**: {{ $task->network->network_number }}
- **Pelanggan**: {{ $task->network->customer->name }}
- **Lokasi**: {{ $task->network->customer->address }}
- **Peran Anda**: {{ ucfirst($user->pivot->role_in_task) }} Teknisi
- **Dibuat oleh**: {{ $task->creator->name ?? 'N/A' }}

@component('mail::button', ['url' => url('/taskorders/' . $task->id)])
Lihat Tiket
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
