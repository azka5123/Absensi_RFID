<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class getUid
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $uid;
    /**
     * Create a new event instance.
     */
    public function __construct($uid)
    {
        $this->uid = $uid;
    }

    public function broadcastAs(): string
    {
        return 'get.uid';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('uids'),
        ];
    }
}
