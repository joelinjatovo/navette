<?php

namespace App\Models;

use App\Events\RideItem\RideItemActived;
use App\Events\RideItem\RideItemAttached;
use App\Events\RideItem\RideItemCanceled;
use App\Events\RideItem\RideItemCompleted;
use App\Events\RideItem\RideItemDetached;
use App\Events\RideItem\RideItemDriverArrived;
use App\Events\RideItem\RideItemStarted;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

class RideItem extends Pivot
{
    
    const TYPE_PICKUP = 'pickup';
    
    const TYPE_DROP = 'drop';
    
    const STATUS_PING = 'ping';
    
    const STATUS_ACTIVE = 'active';
    
    const STATUS_NEXT = 'next';
  
    const STATUS_ARRIVED = 'arrived';
    
    const STATUS_STARTED = 'started';
    
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
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'actived' => RideItemActived::class,
        'attached' => RideItemAttached::class,
        'canceled' => RideItemCanceled::class,
        'completed' => RideItemCompleted::class,
        'detached' => RideItemDetached::class,
        'driver-arrived' => RideItemDriverArrived::class,
        'started' => RideItemStarted::class,
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
            if ( empty( $model->{$model->getKeyName()} ) ) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    
    /**
     * Active ride point (Item is attached to the ride)
     */
    public function active()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->actived_at = now();
        $this->save();
		
		$this->fireModelEvent('actived');
    }
    
    /**
     * Arrive ride point
     */
    public function arrive()
    {
        $this->status = self::STATUS_ARRIVED;
		$this->arrived_at = now();
        $this->save();
		
		$this->fireModelEvent('driver-arrived');
    }
    
    /**
     * Cancel ride point
     */
    public function cancel()
    {
        $this->status = self::STATUS_CANCELED;
        $this->canceled_at = now();
        $this->save();
		
		$this->fireModelEvent('canceled');
    }
	
    /**
     * Pick or Drop ride point
     */
    public function pickOrDrop()
    {
        if($this->type == self::TYPE_PICKUP){
			$this->status = self::STATUS_STARTED;
			$this->started_at = now();
			$this->save();
			$this->fireModelEvent('started');
        }else{
			$this->status = self::STATUS_COMPLETED;
			$this->started_at = now();
			$this->save();
			$this->fireModelEvent('completed');
        }
    }
    
    /**
     * Check if ride is arrivable
     */
    public function isArrivable()
    {
        return (self::STATUS_NEXT == $this->status) 
            && (self::TYPE_PICKUP == $this->type);
    }
    
    /**
     * Check if ride is cancelable
     */
    public function isCancelable()
    {
        return (self::STATUS_COMPLETED != $this->status) && (self::STATUS_CANCELED != $this->status) ;
    }
    
    /**
     * Check if ride is dropable
     */
    public function isDropable()
    {
        return (self::STATUS_NEXT == $this->status) && (self::TYPE_DROP == $this->type);
    }
    
    /**
     * Check if ride is pickable
     */
    public function isPickable()
    {
        return (self::STATUS_ARRIVED == $this->status) && (self::TYPE_PICKUP == $this->type);
    }
    
    /**
     * Get the item related to this point.
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    
    /**
     * Get the ride related to this ride point.
     */
    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
    }
}