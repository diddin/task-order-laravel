@php
    $role = $task->creator->role->name;
    $routeName = $role . '.tasks.show';
@endphp

@component('mail::message')
# Tiket Update

Tiket dengan ID {{ $task->id }} telah diperbarui.

Status terbaru: {{ $data['status'] ?? '-' }}

@component('mail::button', ['url' => route($routeName, ['task' => $task->id])])
Lihat Tiket
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent