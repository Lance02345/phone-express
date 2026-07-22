<?php

namespace App\Mail;

use App\Models\StaffInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public StaffInvitation $invitation, public string $acceptUrl) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->invitation->subject ?: 'Your Phone Express staff invitation');
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.staff-invitation');
    }
}
