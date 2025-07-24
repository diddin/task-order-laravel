@component('mail::message')
# Halo {{ $user->name }}

Anda telah ditugaskan dalam task berikut:

### Detail Tugas:
- **Judul / Rincian**: {{ $task->detail }}
- **Status**: {{ ucfirst($task->action ?? 'Belum ditentukan') }}
- **Peran Anda**: {{ ucfirst($user->pivot->role_in_task) }}
- **Dibuat oleh**: {{ $task->creator->name ?? 'N/A' }}

@component('mail::button', ['url' => url('/taskorders/' . $task->id)])
Lihat Task
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
