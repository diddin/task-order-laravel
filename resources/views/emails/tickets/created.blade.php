<x-mail::message>
# Hai, {{ $user->name }}

Tiket Anda telah dibuat:

{{-- - **Judul**: {{ $ticket->title }} --}}
- **Deskripsi**: {{ $task->detail }}

<x-mail::button :url="url('/tasks/' . $task->id)">
Tampilkan Tiket
</x-mail::button>

Terimakasih,<br>
{{ config('app.name') }}
</x-mail::message>

{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}



{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ticket Created</title>
    <style>
        /* Styling here */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Hi {{ $ticket->user->name ?? 'User' }},</h1>
    <p>Your ticket has been created:</p>
    <p><strong>Title:</strong> {{ $ticket->title }}</p>
    <p><strong>Description:</strong><br>{{ $ticket->description }}</p>

    <p>
        <a href="{{ url('/tickets/' . $ticket->id) }}" class="btn">View Ticket</a>
    </p>

    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html> --}}
