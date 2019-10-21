<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Visitor;

class EventInvitation
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event;
    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct($event)
    {
        $this->event=$event;
    }

}
