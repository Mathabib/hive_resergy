<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserInvitationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $plainPassword;

    public function __construct($name, $email, $plainPassword)
    {
        $this->name = $name;
        $this->email = $email;
        $this->plainPassword = $plainPassword;
    }

    public function build()
    {
        return $this->subject('Welcome to Resindo Indonesia')
                    ->view('emails.new_user_invitation');
    }
}
