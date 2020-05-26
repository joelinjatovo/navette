<?php

namespace App\Models;

use App\Events\ItemStatusChanged;
use App\Events\OrderStatusChanged;
use App\Events\RideStatusChanged;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    
    public const TYPE_GO = 'go';
    
    public const TYPE_BACK = 'back';
    
    public const STATUS_PING = 'ping';
    
    public const STATUS_ACTIVE = 'active';
    
    public const STATUS_NEXT = 'next';
  
    public const STATUS_ARRIVED = 'arrived';
    
    public const STATUS_ONLINE = 'online';
    
    public const STATUS_CANCELED = 'canceled';
    
    public const STATUS_COMPLETED = 'completed';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'distance',
        'distance_value',
        'duration',
        'duration_value',
        'direction',
        'ride_at',
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
    
    public function setRideAtAttribute($value)
    {
       $this->attributes['ride_at'] = Carbon::parse($value);
    }
    
    /**
     * Get the driver that owns the order.
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
    
    /**
     * Get the order's note.
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }
    
    /**
     * Get the order that owns the item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    
    /**
     * Get the ride that owns the item.
     */
    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
    }
    
    /**
     * Get the ride points.
     */
    public function ridePoints()
    {
        return $this->hasMany(RidePoint::class, 'item_id', 'id');
    }
    
    /**
     * Get the point that owns the item.
     */
    public function point()
    {
        return $this->belongsTo(Point::class, 'point_id');
    }
    
    /**
     * Get the user that owns the order item.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Check if ride is cancelable
     */
    public function cancelable()
    {
        return (self::STATUS_COMPLETED != $this->status) && (self::STATUS_CANCELED != $this->status) ;
    }
    
    /**
     * Finish ride point
     */
    public function cancel()
    {
        $oldStatus = $this->status;
        $newStatus = self::STATUS_CANCELED;
        
        $this->status = $newStatus;
        $this->save();
                
        // Notify *customer
        event(new ItemStatusChanged($this, 'updated', $oldStatus, $newStatus));
        
		// Cancel ride point
        $point = $this->point;
        $ride = $this->ride;
        if($point && $ride){
            $newStatus = RidePoint::STATUS_CANCELED;
            $ride->points()->updateExistingPivot($point->getKey(), ['status' => $newStatus]);
        }
        
        // Cancel order if all items is canceled
        $order = $this->order;
        if($order){
            $count = $order->items()->where('items.status', '!=', Item::STATUS_CANCELED)->count();
            if($count==0){
                $oldStatus = $order->status;
                $newStatus = Order::STATUS_CANCELED;

                $order->status = $newStatus;
                $order->save();

                // Notify *customer
                event(new OrderStatusChanged($order, 'updated', $oldStatus, $newStatus));
            }
        }
        
    }
}
