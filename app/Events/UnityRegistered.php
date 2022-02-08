<?php

namespace App\Events;

use Illuminate\Auth\Events\Registered;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UnityRegistered extends Registered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $isUnity;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user,$isUnity)
    {
        parent::__construct($user);
       $this->isUnity= $isUnity;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    
}
