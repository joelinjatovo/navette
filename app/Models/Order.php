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
    
    /**
     * The attributes that are datetime type.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'payed_at', 'canceled_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'place', 'amount', 'total', 'subtotal', 'currency', 'vat', 'preordered', 'privatized', 'payment_type', 'canceled_at', 'canceled_by', 'canceler_role', 'ip_address', 'mac_address',
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
     * Get the car privatized with the order.
     */
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
    
    /**
     * Get the user that canceled the order.
     */
    public function canceler()
    {
        return $this->belongsTo(User::class, 'canceled_by');
    }
    
    /**
     * Get the club that owns the order.
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
    
    /**
     * Get the driver that owns the order.
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
    
    /**
     * Get the first order. (parent)
     */
    public function first()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    
    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the ride that owns the order.
     */
    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }
    
    /**
     * Get the phones that owns the order.
     */
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
    
    /**
     * The points that belong to the order.
     */
    public function points()
    {
        return $this->belongsToMany(Point::class, 'order_point')->using(OrderPoint::class)->withPivot(['type']);
    }
    
    /**
     * Get second order that owns the first order (Child)
     */
    public function second()
    {
        return $this->hasOne(Order::class);
    }
    
    /**
     * Get zone that owns the order
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
    
    /**
     * Check if order is cancelable
     */
    public function cancelable()
    {
        switch($this->status){
            case self::STATUS_TERMINATED:
            case self::STATUS_CLOSED:
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
    public function cancel()
    {
        $this->status = self::STATUS_CANCELED;
        return $this->save();
    }
}
