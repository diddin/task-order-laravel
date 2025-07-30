<?php

namespace App\Listeners;

use App\Models\Chat;
use App\Events\ChatRead;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUnreadChatCount
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    // public function handle(object $event): void
    // {
    //     //
    // }
    
    public function handle(ChatRead $event)
    {
        $unreadCount = Chat::unread()->forUser($event->userId)->count();

        Cache::put("unread_chats_user_{$event->userId}", $unreadCount, now()->addMinutes(5));

        // Simulasi log agar tahu listener jalan
        logger("Unread chat count for user {$event->userId} updated to {$unreadCount}");
    }
}
