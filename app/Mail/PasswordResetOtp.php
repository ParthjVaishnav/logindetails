<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;



class PasswordResetOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $emailMessage;
    public $subject;
    public $otp;

    public function __construct(string $emailMessage, string $subject, string $otp)
    {
        $this->emailMessage = $emailMessage;
        $this->subject = $subject;
        $this->otp = $otp;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'otp',
            with: [
                'message' => $this->emailMessage,
                'otp' => $this->otp,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
