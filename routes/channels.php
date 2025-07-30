<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('public-chat', function () {
//     return true; // Siapa saja bisa dengar
// });

// Broadcast::channel('chat.{userId}', function ($user, $userId) {
//     return (int) $user->id === (int) $userId;
// });

Broadcast::channel('private-chat.{userId}', function ($user, $userId) {
    return true; // HANYA UNTUK TESTING, JANGAN PRODUKSI
});
