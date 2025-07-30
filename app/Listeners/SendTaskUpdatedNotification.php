<?php

namespace App\Listeners;

use App\Events\TaskUpdated;
use App\Mail\TaskUpdatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskUpdatedNotification
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
    public function handle(TaskUpdated $event)
    {
        $recipient = $event->task->user->email ?? 'admin@example.com'; // fallback jika user null

        Mail::to($recipient)
            ->send(new TaskUpdatedMail($event->task, $event->data));
    }
}
