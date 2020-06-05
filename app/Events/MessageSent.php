<?php

namespace App\Events;

use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	private $message;
	
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
		switch($this->message->messageable_type){
			case \App\Models\Discution::class: return new PrivateChannel('App.Discution.' . $this->message->messageable_id);
			case \App\Models\Ride::class: return new PrivateChannel('App.Ride.' . $this->message->messageable_id);
			case \App\Models\RideItem::class: return new PrivateChannel('App.RideItem.' . $this->message->messageable_id);
			case \App\Models\Item::class: return new PrivateChannel('App.Item.' . $this->message->messageable_id);
		}
        return new PrivateChannel('App.User.'.$this->message->user_id);
    }
    
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'chat';
    }
}
