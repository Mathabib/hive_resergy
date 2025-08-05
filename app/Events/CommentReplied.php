<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentReplied
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reply;

    public function __construct(Comment $reply)
    {
        // Simpan reply dan muat relasi parent->user
        $this->reply = $reply->loadMissing('parent.user');
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
