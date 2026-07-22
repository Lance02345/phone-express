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
        return new Envelope(subject: 'You’re invited to the Phone Express team');
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.staff-invitation',
            text: 'mail.staff-invitation-text',
        );
    }
}
