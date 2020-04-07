<?php

namespace App\Notifications;

use App\Models\Ride;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class RideStatus extends Notification
{
    use Queueable;
    
    protected $ride;
    
    protected $old_status;
    
    protected $new_status;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ride $ride, $new_status, $old_status = null)
    {
        $this->ride = $ride;
        $this->old_status = $old_status;
        $this->new_status = $new_status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'nexmo'];
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
            'id' => $this->ride->id,
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
                    ->content('Your SMS message content sayes that that ride is created');
    }
}
