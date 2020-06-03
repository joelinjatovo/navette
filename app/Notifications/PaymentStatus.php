<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class PaymentStatus extends Notification
{
    use Queueable;
    
    protected $order;
    
    protected $status;
	
    protected $payment_type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($status, $payment_type, Order $order)
    {
        $this->order = $order;
        $this->status = $status;
        $this->payment_type = $payment_type;
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
		$args = ['order' => $this->order->getKey(), 'payment_type' => $this->payment_type];
		$message = rans('Le paiement de la commande N#:order par :payment_type', $args)
		if($this->status == 'paid'){
			$message = trans('Le paiement de la commande N#:order par :payment_type a ete bien recu.', $args);
		}elseif($this->status == 'failed'){
			$message = trans('Le paiement de la commande N#:order par :payment_type a echoue.', $args);
		}
		
        return [
            'order_id' => $this->order->getKey(),
            'user_id' => $this->order->user?$this->order->user->getKey():null,
            'status' => $this->status,
            'payment_type' => $this->payment_type,
			'message' => $message
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
                    ->content('Your SMS message content sayes that order status is changed');
    }
}
