<?php

/**
 * Created by PhpStorm.
 * User: antoniobg
 * Date: 1/12/17
 * Time: 2:08 PM
 */
namespace So2platform\Publicprofile\Events;


use Illuminate\Broadcasting\Channel;
use Symfony\Component\EventDispatcher\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class FeedbacksEvent extends Event implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $channel;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($channel)
    {
        $this->channel = $channel;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [$this->channel];
    }
}