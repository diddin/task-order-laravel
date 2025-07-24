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
        $task = $event->task;

        // // Kirim email langsung tanpa queue
        // Mail::to($ticket->assignedUser->email)->send(new TicketCreatedMail($ticket));

        // email ke user assigned Teknisi (PIC dan ONSITE)
        foreach ($task->assignedUsers as $user) {
            //Mail::to($user->email)->send(new TaskAssignedMail($task, $user));

            Mail::to($user->email)->send(new TicketCreatedMail($task, $user));
        }
    }
}
