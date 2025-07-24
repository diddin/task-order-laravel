<?php

namespace App\Mail;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Address;

class TicketCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Task $task;
    public User $user;

    /**
     * Create a new message instance.
     */
    public function __construct(Task $task, User $user)
    {
        $this->task = $task;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tiket Baru #' . $this->task->id . ' Dibuat',
            //from: new Address('support@yourdomain.com', 'Support Team'),
            // replyTo: new Address(config('mail.reply_to.address'), config('mail.reply_to.name')),
            // tags: ['ticket-created', 'ticket-id-' . $this->ticket->id],
            // cc: [
            //     new Address(config('mail.cc.address'), config('mail.cc.name')),
            //     new Address('ccuser@example.com', 'CC User'),
            //     new Address('manager@example.com', 'Manager Name'),
            // ],
            // bcc: [
            //     new Address(config('mail.bcc.address'), config('mail.bcc.name')),
            //     new Address('audit@example.com', 'Audit Department'),
            // ],
            //to: [$this->ticket->assignedUser->email => $this->ticket->assignedUser->name],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.tickets.created',
            //view: 'emails.tickets.created', // <-- HTML biasa, bukan markdown
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            // Attachment::fromPath(storage_path('app/tickets/' . $this->ticket->file))
            //           ->as('TicketAttachment.pdf')
            //           ->withMime('application/pdf'),
        ];
    }
}
