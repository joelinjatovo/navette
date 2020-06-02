<?php

namespace App\Notifications;

use App\Models\RidePoint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class BaseRidePointNotification extends Notification
{
    use Queueable;
    
    protected $ridepoint;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(RidePoint $ridepoint)
    {
        $this->ridepoint = $ridepoint;
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
        return $this->ridepoint->attributesToArray();
    }
        
}
