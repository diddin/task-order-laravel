<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Mail\TicketCreatedMail;
use App\Mail\TaskAssignedMail;
use App\Mail\TaskCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

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

        // Kirim email ke semua user yang ditugaskan (PIC dan Onsite)
        foreach ($task->assignedUsers as $user) {
            Mail::to($user->email)->send(new TaskAssignedMail($task, $user));
            //Mail::to($user->email)->send(new TicketCreatedMail($task, $user));
        }

        Log::info('Creator:', ['creator' => $task->creator->email]);

        // Kirim email ke pembuat task
        if (optional($task->creator)->email) {
            Mail::to($task->creator->email)->send(new TaskCreatedMail($task));
        }
    }
}
