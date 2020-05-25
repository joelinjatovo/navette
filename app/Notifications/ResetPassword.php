<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class ResetPassword extends Notification
{
    /**
     * Paaword reset code
     *
     * @var String
     */
    public $passwordResetCode;
    
    /**
     * The callback that should be used to build the nexmo message.
     *
     * @var \Closure|null
     */
    public static $toPhoneCallback;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        $this->passwordResetCode = $code;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return [];
    }
    
    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        if (static::$toPhoneCallback) {
            return call_user_func(static::$toPhoneCallback, $notifiable, $this->passwordResetCode);
        }
        
        return (new NexmoMessage)
                    ->content( Lang::get('Navette code: ') . $this->passwordResetCode);
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toPhoneUsing($callback)
    {
        static::$toPhoneCallback = $callback;
    }
}
