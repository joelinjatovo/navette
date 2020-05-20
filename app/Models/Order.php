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
    
    public const TYPE_CUSTOM = 'custom';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'place',
        'privatized',
        'preordered',
    ];
    
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
     * Get the car privatized with the order.
     */
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
    
    /**
     * Get the club that owns the order.
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
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
     * Get status string
     */
    public function status()
    {
		switch($this->status){
			case self::STATUS_PING: return trans('messages.status.ping');
			case self::STATUS_ON_HOLD: return trans('messages.status.on-hold');
			case self::STATUS_PROCESSING: return trans('messages.status.processing');
			case self::STATUS_OK: return trans('messages.status.ok');
			case self::STATUS_ACTIVE: return trans('messages.status.active');
			case self::STATUS_COMPLETED: return trans('messages.status.completed');
			case self::STATUS_CANCELED: return trans('messages.status.canceled');
		}
        return trans('messages.status.unknown');
    }
    
    /**
     * Get zone that owns the order
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
    
    /**
     * Set VAT tax
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
        $this->total = $this->subtotal + $this->subtotal * $this->vat;
        
        return $this;
    }
    
    /**
     * Set zone and calculate
     */
    public function setZone(Zone $zone)
    {
        $this->zone_id = $zone->getKey();
        if($this->privatized){
            $this->amount = $zone->privatizedPrice;
        }else{
            $this->amount = $zone->price;
        }
        $this->currency = $zone->currency;
        $this->subtotal = $this->place * $this->amount;
        $this->total = $this->subtotal + $this->subtotal * $this->vat;
        
        return $this;
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
