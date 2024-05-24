<?php
namespace App\Events;

use App\Models\Iruzkina;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentAdded implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
    public $username;

    public function __construct(Iruzkina $comment, $username)
    {
        $this->comment = $comment;
        $this->username = $username;
    }

    public function broadcastOn()
    {
        return new Channel('public-channel');
    }
}
