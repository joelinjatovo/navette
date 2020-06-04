<?php

namespace App\Models;

use App\Events\Item\ItemActived;
use App\Events\Item\ItemCanceled;
use App\Events\Item\ItemCompleted;
use App\Events\Item\ItemDeleted;
use App\Events\Item\ItemDetached;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    
    public const TYPE_GO = 'go';
    
    public const TYPE_BACK = 'back';
    
    public const STATUS_ACTIVE = 'active';
  
    public const STATUS_CANCELED = 'canceled';
    
    public const STATUS_COMPLETED = 'completed';
    
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
        'detached' => ItemDetached::class,
    ];
    
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
     * Get suggested rides
     */
    public function getSuggestions($max = 5)
    {
		$rides = [];
		
		/*
		if( !$this->club || !is_array($this->items) || !isset($this->items[0]) ){
			return [];
		}
		*/
		
		$items = Item::join('orders', 'orders.id', '=', 'items.order_id')
			->where('orders.club_id', '=', $this->club->id)
			->where('orders.status', Order::STATUS_ACTIVE)
			->whereNotIn('items.status', [Item::STATUS_PING, Item::STATUS_CANCELED, Item::STATUS_COMPLETED])
			->with('ride')
			->get();
		
		$ids = [];
		foreach($items as $item){
			if(!$item->ride) continue;
			if(in_array($item->ride->id, $ids)) continue;
			$distance = $item->distance($this->items[0]);
			if( $distance <= $max ) {
				$rides[] = $item->ride;
				$ids[] = $item->ride->id;
			}
		}
		
        return $rides;
    }
    
    /**
     * Check if order item is cancelable
     */
    public function isCancelable()
    {
        return !in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_CANCELED]);
    }
    
    /**
     * Check if item is one car
     */
    public function isOneCar()
    {
		return $this->order && $this->order->isOneCar();
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
     * Get the ride chosen by the user
     */
    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
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
     * Get the user that owns the order item.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
