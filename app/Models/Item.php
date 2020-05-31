<?php

namespace App\Models;

use App\Events\Item\ItemActived;
use App\Events\Item\ItemCanceled;
use App\Events\Item\ItemCompleted;
use App\Events\Item\ItemDateDelayed;
use App\Events\Item\ItemDateForwarded;
use App\Events\Item\ItemDateInited;
use App\Events\Item\ItemDeleted;
use App\Events\Item\ItemDriverArrived;
use App\Events\Item\ItemNexted;
use App\Events\Item\ItemStarted;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    
    public const TYPE_GO = 'go';
    
    public const TYPE_BACK = 'back';
    
    public const STATUS_ACTIVE = 'active';
  
    public const STATUS_ARRIVED = 'arrived';
    
    public const STATUS_CANCELED = 'canceled';
    
    public const STATUS_COMPLETED = 'completed';
    
    public const STATUS_NEXT = 'next';
    
    public const STATUS_ONLINE = 'online';
    
    public const STATUS_PING = 'ping';
    
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
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'actived' => ItemActived::class,
        'canceled' => ItemCanceled::class,
        'completed' => ItemCompleted::class,
        'deleted' => ItemDeleted::class,
        'date-delayed' => ItemDateDelayed::class,
        'date-forwarded' => ItemDateForwarded::class,
        'date-inited' => ItemDateInited::class,
        'driver-arrived' => ItemDriverArrived::class,
        'nexted' => ItemNexted::class,
        'started' => ItemStarted::class,
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
     * Active item (Item is attached to the ride)
     */
    public function active()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->actived_at = now();
        $this->save();
		
		$this->fireModelEvent('actived');
    }
    
    /**
     * Driver arrive at the point
     */
    public function arrive()
    {
        $this->status = self::STATUS_ARRIVED;
        $this->arrived_at = now();
        $this->save();
		
		$this->fireModelEvent('driver-arrived');
    }
    
    /**
     * Cancel order iten
     */
    public function cancel()
    {
        $this->status = self::STATUS_CANCELED;
        $this->canceled_at = now();
        $this->save();
		
		$this->fireModelEvent('canceled');
    }
    
    /**
     * Complete the order item
     */
    public function complete()
    {
        $this->status = self::STATUS_COMPLETED;
        $this->completed_at = now();
        $this->save();
		
		$this->fireModelEvent('completed');
    }
    
    /**
     * Get the driver that owns the order.
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
    
    /**
     * Set order iten as next
     */
    public function next()
    {
        $this->status = self::STATUS_NEXT;
        $this->save();
		
		$this->fireModelEvent('nexted');
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
     * Get the point that owns the item.
     */
    public function point()
    {
        return $this->belongsTo(Point::class, 'point_id');
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
    
    public function setRideAtAttribute($value)
    {
       $this->attributes['ride_at'] = Carbon::parse($value);
    }
    
    /**
     * Start the order item
     */
    public function setStartDate($date)
    {
		if($this->start_at){
			if($model->start_at->greaterThan($date)){
				$this->start_at = $date;
        		$this->save();
				$this->fireModelEvent('date-delayed');
			}else{
				$this->start_at = $date;
        		$this->save();
				$this->fireModelEvent('date-forwarded');
			}
		}else{
			$this->start_at = $date;
        	$this->save();
			$this->fireModelEvent('date-inited');
		}
    }
    
    /**
     * Start the order item
     */
    public function start()
    {
        $this->status = self::STATUS_STARTED;
        $this->started_at = now();
        $this->save();
		
		$this->fireModelEvent('started');
    }
    
    /**
     * Get the user that owns the order item.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Check if order item is cancelable
     */
    public function isCancelable()
    {
        return !in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_CANCELED]);
    }
}
