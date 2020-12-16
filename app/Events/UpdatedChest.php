<?php

namespace App\Events;

use App\Models\Chest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdatedChest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chest;

    /**
     * Create a new event instance.
     *
     * @param Chest $chest
     */
    public function __construct(Chest $chest)
    {
        $this->chest = $chest;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        logger('channel: chest.' . $this->chest->getIpAddress());
        logger(request()->ip());
        return new Channel('chest.' . $this->chest->getIpAddress());
    }
}
