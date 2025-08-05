<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentAddedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $comment;
    public $task;

    public function __construct($comment, $task)
    {
        $this->comment = $comment;
        $this->task = $task;
    }

    public function build()
    {
        return $this->subject('New Comment on Task: ' . $this->task->nama_task)
                    ->view('emails.comment_added');
    }
}
