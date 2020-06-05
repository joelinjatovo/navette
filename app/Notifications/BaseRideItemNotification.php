<?php

namespace App\Notifications;

use App\Models\RideItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class BaseRideItemNotification extends Notification
{
    use Queueable;
    
    protected $rideitem;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(RideItem $rideitem)
    {
        $this->rideitem = $rideitem;
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
        return $this->rideitem->attributesToArray();
    }
        
}