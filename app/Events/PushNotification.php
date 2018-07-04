<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PushNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public $mid;

    public $name;

    /**
     * PushNotification constructor.
     * @param $mid
     * @param $name
     * @param $message
     */
    public function __construct($mid, $name, $message)
    {
        $this->mid = $mid;
        $this->message = $message;
        $this->name = $name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['notification'];
        //return new PrivateChannel('channel-name');

    }

}
