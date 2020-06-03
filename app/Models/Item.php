<?php

namespace App\Models;

use App\Events\Item\ItemActived;
use App\Events\Item\ItemCanceled;
use App\Events\Item\ItemCompleted;
use App\Events\Item\ItemStartDelayed;
use App\Events\Item\ItemStartForwarded;
use App\Events\Item\ItemStartInited;
use App\Events\Item\ItemStartRefreshed;
use App\Events\Item\ItemDeleted;
use App\Events\Item\ItemDetached;
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
    
    public const STATUS_PING = 'ping';
    
    public const STATUS_STARTED = 'started';
    
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
        'detached' => ItemDetached::class,
        'start-delayed' => ItemStartDelayed::class,
        'start-forwarded' => ItemStartForwarded::class,
        'start-inited' => ItemStartInited::class,
        'start-refreshed' => ItemStartRefreshed::class,
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
    * Titre : Calcul la distance entre 2 points en km                                                                                         
	*/
	function distance(Item $item, $unit = 'km', $decimals = 2) 
	{
		if(!$this->point) return 0;
		
		if(!$item->point) return 0;
		
		return $this->point->distance($item->point, $unit, $decimals);
	}
    
    /**
     * Check if order item is cancelable
     */
    public function isCancelable()
    {
        return !in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_CANCELED]);
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
     * Get the rides.
     */
    public function rides()
    {
        return $this->belongsToMany(Ride::class, 'ride_item')
                    ->using(RideItem::class)
                    ->withPivot([
                        'id', 
                        'status', 
                        'type', 
                        'place', 
                        'order', 
                        'distance', 
                        'distance_value', 
                        'duration',
                        'duration_value',
                        'direction',
						'arrived_at', 
						'start_at',
						'started_at',
						'canceled_at',
						'completed_at',
                    ])->orderBy('order', 'asc');
    }
    
    /**
     * Get the ride items that owns the item.
     */
    public function rideitems()
    {
        return $this->hasMany(RideItem::class, 'item_id')->with('ride');
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
		if($date==null){
			$this->start_at = $date;
			$this->save();
			$this->fireModelEvent('start-refreshed');
			return;
		}
		
		if($this->start_at){
			if($model->start_at->greaterThan($date)){
				$this->start_at = $date;
        		$this->save();
				$this->fireModelEvent('start-delayed');
			}else{
				$this->start_at = $date;
        		$this->save();
				$this->fireModelEvent('start-forwarded');
			}
		}else{
			$this->start_at = $date;
        	$this->save();
			$this->fireModelEvent('start-inited');
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
}
