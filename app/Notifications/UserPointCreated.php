<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class UserPointCreated extends Notification
{
    use Queueable;

    public $user;
    
    public $point;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(\App\Models\User $user, \App\Models\Point $point)
    {
        $this->user = $user;
        $this->point = $point;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'phone' => $this->user->phone,
            ],
            'point' => [
                'name' => $this->point->name,
                'lat' => $this->point->lat,
                'lng' => $this->point->lng,
                'alt' => $this->point->alt,
            ],
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
                    ->content('Your SMS message content');
    }
}
