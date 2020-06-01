<?php

namespace App\Notifications;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class PickupDate extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $item;
	
    protected $duration;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Item $item, $duration)
    {
        $this->item = $item;
        $this->duration = $duration;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'item_id' => $this->item->getKey(),
			'delay' => $this->duration,
			'oldStatus' => 'active',
			'newStatus' => 'next',
			'message' => trans('Votre chauffeur arrivera dans :delay.', ['delay' => $this->duration])
        ];
    }
    
    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
                    ->content(trans('Votre chauffeur arrivera dans :delay.', ['delay' => $this->duration]));
    }
}
