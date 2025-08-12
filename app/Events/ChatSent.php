<?php

namespace App\Events;

use App\Models\Chat;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ChatSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;

    /**
     * Create a new event instance.
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Tentukan channel tempat event akan disiarkan.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            // ✅ PRIVATE channel — hanya bisa diakses oleh user yang diotorisasi
            // new PrivateChannel('private-chat.' . $this->chat->to_user_id),

            // ✅ PUBLIC channel — bisa didengarkan siapa saja tanpa autentikasi
            new Channel('public-chat'),
        ];
    }

    /**
     * Data tambahan yang akan dikirim saat broadcast.
     */
    public function broadcastWith()
    {
        return [
            'chat' => [
                'id' => $this->chat->id,
                'message' => $this->chat->message,
                'from_user_id' => (int) $this->chat->from_user_id, // ✅ pastikan ini number
                'to_user_id' => (int) $this->chat->to_user_id,
                'created_at' => $this->chat->created_at,
                'from_user' => [
                    'id' => $this->chat->fromUser->id,
                    'name' => $this->chat->fromUser->name,
                ]
            ]
        ];
    }

    /**
     * Nama event di sisi frontend (opsional).
     */
    public function broadcastAs()
    {
        return 'chat.sent';
    }
}
