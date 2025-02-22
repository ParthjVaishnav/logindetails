<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ipAddress;
    public $device;

    public function __construct($user, $ipAddress, $device)
    {
        $this->user = $user;
        $this->ipAddress = $ipAddress;
        $this->device = $device;
    }

    public function build()
    {
        return $this->subject('New Login Detected')
                    ->view('emails.login_alert');
    }
}
