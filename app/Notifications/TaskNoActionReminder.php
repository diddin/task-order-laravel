<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class TaskNoActionReminder extends Notification
{
    use Queueable;

    public Task $task;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        Log::info("Mengirim email ke {$notifiable->email} untuk task {$this->task->id}");

        return (new MailMessage)
            ->subject('Reminder: Tiket Belum Dikerjakan')
            // ->line('Tiket #' . $this->task->task_number . ' masih belum dikerjakan sejak dibuat lebih dari 6 jam.')
            ->line('Tiket #' . $this->task->task_number . ' masih belum dikerjakan sejak dibuat.')
            ->action('Lihat Tiket', url('/tasks/'.$this->task->id))
            ->line('Segera tindak lanjuti tiket ini.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
