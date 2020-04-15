<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    
    use SoftDeletes;
    
    public const PAYMENT_TYPE_CASH = 'cash';
    
    public const PAYMENT_TYPE_STRIPE = 'stripe';
    
    public const PAYMENT_TYPE_PAYPAL = 'paypal';
    
    public const PAYMENT_TYPE_APPLE_PAY = 'apple_pay';
    
    public const RIDE_STATUS_NONE = 'none';
    
    public const RIDE_STATUS_PING = 'ping';
    
    public const RIDE_STATUS_NEXT_UP = 'next-up';
    
    public const RIDE_STATUS_ONLINE = 'online';
    
    public const RIDE_STATUS_NEXT_DOWN = 'next-down';
    
    public const RIDE_STATUS_COMPLETED = 'completed';
    
    public const RIDE_STATUS_CANCELED = 'canceled';
    
    public const STATUS_PING = 'ping'; 
    
    public const STATUS_ON_HOLD = 'on-hold';
    
    public const STATUS_PROCESSING = 'processing';
    
    public const STATUS_OK = 'ok';
    
    public const STATUS_ACTIVE = 'active';
    
    public const STATUS_CANCELED = 'canceled';
    
    public const STATUS_COMPLETED = 'completed';
    
    public const TYPE_GO = 'go';
    
    public const TYPE_BACK = 'back';
    
    public const TYPE_GO_BACK = 'go-back';
    
    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if( empty( $model->user_id ) && auth()->check() ) {
                $model->user_id = auth()->user()->id;
            }
        });
    }
    
    /**
     * Get the user that canceled the order.
     */
    public function canceler()
    {
        return $this->belongsTo(User::class, 'canceler_id');
    }
    
    /**
     * Get the order items
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'order_id');
    }
    
    /**
     * Get the order's note.
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }
    
    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the payment tokens
     */
    public function paymentTokens()
    {
        return $this->hasMany(PaymentToken::class, 'order_id');
    }
    
    /**
     * Check if order is cancelable
     */
    public function cancelable()
    {
        switch($this->status){
            case self::STATUS_COMPLETED:
            case self::STATUS_CANCELED:
                return false;
            default:
                return true;
        }
    
        return true;
    }
    
    /**
     * Cancel order
     */
    public function cancel(User $user)
    {
        $this->status = self::STATUS_CANCELED;
        $this->canceled_at = now();
        $this->canceler_role = $user->isAdmin() ? Role::ADMIN : ( $user->isDriver() ? Role::DRIVER : Role::CUSTOMER );
        $this->canceler_id = $user->getKey();
        $this->save();
    }
}
