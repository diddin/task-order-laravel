<?php

namespace App\Listeners;

use App\Events\ChatSent;
use Illuminate\Support\Facades\Cache;
use App\Models\Chat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUnreadChatCountOnSent
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
    public function handle(ChatSent $event)
    {
        $receiverId = $event->chat->to_user_id;

        $unreadCount = Chat::unread()->forUser($receiverId)->count();

        Cache::put("unread_chats_user_{$receiverId}", $unreadCount, now()->addMinutes(5));

        logger("Unread chat count updated for user {$receiverId}: {$unreadCount}");
    }
}
