<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatRead
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    // use InteractsWithSockets,

    public $userId; // user yang chatnya diupdate
    public $unreadCount;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $unreadCount = 0)
    {
        $this->userId = $userId;
        $this->unreadCount = $unreadCount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->userId),
        ];
    }

    public function broadcastWith()
    {
        return [
            'unreadCount' => $this->unreadCount,
        ];
    }
}
