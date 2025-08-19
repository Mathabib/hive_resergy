<?php
// app/Mail/BroadcastMail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BroadcastMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $messageText;
    public $attachmentPath;

    public function __construct($subjectText, $messageText, $attachmentPath = null)
    {
        $this->subjectText    = $subjectText;
        $this->messageText    = $messageText;
        $this->attachmentPath = $attachmentPath;
    }

    public function build()
    {
        $email = $this
            ->subject($this->subjectText)
            ->view('emails.broadcast')
            ->with([
                'messageText' => $this->messageText
            ]);
        // $email = $this->from(
        //         env('MAIL_FROM_ADDRESS_MARKETING'),
        //         env('MAIL_FROM_NAME_MARKETING')
        //     )
        //     ->subject($this->subjectText)
        //     ->view('emails.broadcast')
        //     ->with([
        //         'messageText' => $this->messageText
        //     ]);

        if ($this->attachmentPath) {
            $email->attach($this->attachmentPath);
        }

        return $email;
    }
}
