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
    
    public const STATUS_ONLINE = 'online';
    
    public const STATUS_NEXT = 'next';
    
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
     * Get the point that owns the item.
     */
    public function point()
    {
        return $this->belongsTo(Point::class);
    }
    
    /**
     * Check if ride is finishable
     */
    public function finishable()
    {
        return self::STATUS_NEXT == $this->status;
    }
    
    /**
     * Finish ride point
     */
    public function finish()
    {
        $oldStatus = $this->status;
        if($this->type == self::TYPE_GO){
            $newStatus = self::STATUS_ONLINE;
        }else{
            $newStatus = self::STATUS_COMPLETED;
        }
        
        $this->status = $newStatus;
        $this->save();
                
        // Notify *customer
        event(new ItemStatusChanged($this, 'updated', $oldStatus, $newStatus));
        
        $point = $this->point;
        $ride = $this->ride;
        if($point && $ride){
            if($this->type == self::TYPE_GO){
                $newStatus = RidePoint::STATUS_ONLINE;
            }else{
                $newStatus = RidePoint::STATUS_COMPLETED;
            }
            $ride->points()->updateExistingPivot($point->getKey(), ['status' => $newStatus]);
        }
            
        
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
        
        $point = $this->point;
        $ride = $this->ride;
        if($point && $ride){
            $newStatus = RidePoint::STATUS_CANCELED;
            $ride->points()->updateExistingPivot($point->getKey(), ['status' => $newStatus]);
        }
        
    }
}
