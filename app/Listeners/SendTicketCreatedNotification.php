<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Mail\TicketCreatedMail;
use App\Mail\TaskAssignedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTicketCreatedNotification
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
    public function handle(TicketCreated $event): void
    {
        // $ticket = $event->task;

        // // Kirim email langsung tanpa queue
        // Mail::to($ticket->assignedUser->email)->send(new TicketCreatedMail($ticket));

        foreach ($event->task->assignedUsers as $user) {
            Mail::to($user->email)->send(new TaskAssignedMail($event->task, $user));
        }
    }
}
