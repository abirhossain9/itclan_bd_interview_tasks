<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TournamentConditionMet
{
    use Dispatchable, SerializesModels;
    /**
     * The data array for the event.
     *
     * @var array
     */
    public array $dataArray;
    /**
     * Create a new event instance.
     */

    public function __construct($data)
    {
        $this->dataArray = $data;
    }

    public function broadcastOn()
    {
        return new Channel('tournament-events');
    }
}
