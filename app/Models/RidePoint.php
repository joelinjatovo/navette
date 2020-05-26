<?php

namespace App\Models;

use App\Events\ItemStatusChanged;
use App\Events\OrderStatusChanged;
use App\Events\RideStatusChanged;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

class RidePoint extends Pivot
{
    
    const TYPE_PICKUP = 'pickup';
    
    const TYPE_DROP = 'drop';
    
    const STATUS_PING = 'ping';
    
    const STATUS_ACTIVE = 'active';
    
    const STATUS_NEXT = 'next';
  
    const STATUS_ARRIVED = 'arrived';
    
    const STATUS_ONLINE = 'online';
    
    const STATUS_COMPLETED = 'completed';
    
    const STATUS_CANCELED = 'canceled';
    
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if ( empty( $model->{$model->getKeyName()} ) ) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    
    /**
     * Check if ride is arrivable
     */
    public function arrivable()
    {
        return (self::STATUS_NEXT == $this->status) 
            && (self::TYPE_PICKUP == $this->type);
    }
    
    /**
     * Arrive ride point
     */
    public function arrive()
    {
        $oldStatus = $this->status;
        $newStatus = self::STATUS_ARRIVED;
        $this->status = $newStatus;
        $this->save();
        
        $item = $this->item();
        if($item)
        {
            $oldStatus = $item->status;
            $newStatus = Item::STATUS_ARRIVED;
            $item->status = $newStatus;
            $item->save();
                
            // Notify *customer
            event(new ItemStatusChanged($item, 'updated', $oldStatus, $newStatus));
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
     * Cancel ride point
     */
    public function cancel()
    {
        $oldStatus = $this->status;
        $newStatus = self::STATUS_CANCELED;
        
        $this->status = $newStatus;
        $this->save();
        
        $item = $this->item();
        if($item)
        {
            $oldStatus = $item->status;
            $newStatus = Item::STATUS_CANCELED;
            $item->status = $newStatus;
            $item->save();
                
            // Notify *customer
            event(new ItemStatusChanged($item, 'updated', $oldStatus, $newStatus));
        }
        
    }
    
    /**
     * Check if ride is dropable
     */
    public function dropable()
    {
        return (self::STATUS_NEXT == $this->status) && (self::TYPE_DROP == $this->type);
    }
    
    /**
     * Check if ride is pickable
     */
    public function pickable()
    {
        return (self::STATUS_ARRIVED == $this->status) && (self::TYPE_PICKUP == $this->type);
    }
    
    /**
     * Pick or Drop ride point
     */
    public function pickOrDrop()
    {
        $oldStatus = $this->status;
        if($this->type == self::TYPE_PICKUP){
            $newStatus = self::STATUS_ONLINE;
        }else{
            $newStatus = self::STATUS_COMPLETED;
        }
        
        $this->status = $newStatus;
        $this->save();
        
        $item = $this->item();
        if($item)
        {
            $oldStatus = $item->status;
            if($item->type == Item::TYPE_GO){
                $newStatus = Item::STATUS_ONLINE;
            }else{
                $newStatus = Item::STATUS_COMPLETED;
            }
            
            $item->status = $newStatus;
            $item->save();
                
            // Notify *customer
            event(new ItemStatusChanged($item, 'updated', $oldStatus, $newStatus));
        }
    }
    
    /**
     * Get the item related to this point.
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    
    /**
     * Get the order related to the item in this point.
     */
    public function order()
    {
        return $this->item()->order();
    }
    
    /**
     * Get the user who has the ride point.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the point related to this ride point.
     */
    public function point()
    {
        return $this->belongsTo(Point::class, 'point_id');
    }
    
    /**
     * Get the ride related to this ride point.
     */
    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
    }
}
