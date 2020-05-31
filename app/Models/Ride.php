<?php

namespace App\Models;

use App\Events\ItemStatusChanged;
use App\Events\RideStatusChanged;
use App\Events\OrderStatusChanged;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ride extends Model
{
    
    use SoftDeletes;
    
    const STATUS_PING = 'ping';
    
    const STATUS_ACTIVE = 'active';
    
    const STATUS_COMPLETABLE = 'completable';
    
    const STATUS_COMPLETED = 'completed';
    
    const STATUS_CANCELABLE = 'cancelable';
    
    const STATUS_CANCELED = 'canceled';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'user_id', 'driver_id', 'car_id',
    ];

    /**
     * The attributes that are datetime type.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'start_at', 'started_at', 'canceled_at', 'completed_at', 'deleted_at',
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
     * Get the card associated with the race.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    
    /**
     * Get the driver associated with the race.
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id', 'id')->with('roles');
    }
    
    /**
     * Get the items
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    
    /**
     * The points that belong to the order.
     */
    public function points()
    {
        return $this->belongsToMany(Point::class, 'ride_point')
                    ->using(RidePoint::class)
                    ->withPivot([
                        'id', 
                        'status', 
                        'type', 
                        'order', 
                        'distance', 
                        'distance_value', 
                        'duration',
                        'duration_value',
                        'direction',
						'arrive_at', 
						'arrived_at', 
						'started_at', 
						'canceled_at', 
						'completed_at',
						'user_id',
						'item_id',
                    ])->orderBy('order', 'asc');
    }
    
    /**
     * Get the user who creates the ride.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Attach item to the ride
     */
    public function attach(Item $item)
    {
		if($item->order && $item->order->car){
			$order = $item->order;
			$car = $item->order->car;
			$driver = $item->order->car->driver;
			$user = $item->user;
			
			$this->points()->attach($item->point->getKey(), [
				'status' => RidePoint::STATUS_PING,
				'type' => ($item->type == Item::TYPE_BACK ? RidePoint::TYPE_DROP : RidePoint::TYPE_PICKUP),
				'order' => 0,
				'item_id' => $item->getKey(),
				'user_id' => $user ? $user->getKey() : null,
			]);

			// Set item status ACTIVE
			$oldStatus = $item->status;
			$newStatus = Item::STATUS_ACTIVE;
			$item->status = $newStatus;
			$item->ride()->associate($this);
			$item->driver()->associate($driver);
			$item->save();
			$event_item = new ItemStatusChanged($item, 'updated', $oldStatus, $newStatus);

			// Set order status ACTIVE
			$oldStatus = $order->status;
			$newStatus = Order::STATUS_ACTIVE;
			$order->status = $newStatus;
			$order->save();
			$event_order = new OrderStatusChanged($order, 'updated', $oldStatus, $newStatus);

			// Triger events
			event($event_item);
			event($event_order);
		}
	}
    
    /**
     * Detach item to the ride
     */
    public function detach(Item $item)
    {
		if($item->order && $item->order->car){
			$order = $item->order;
			$car = $item->order->car;
			$driver = $item->order->car->driver;
			$user = $item->user;
			
			$this->points()->detach($item->point->getKey());

			// Set item status PING
			$oldStatus = $item->status;
			$newStatus = Item::STATUS_PING;
			$item->status = $newStatus;
			$item->ride()->associate($this);
			$item->driver()->associate($driver);
			$item->save();
			$event_item = new ItemStatusChanged($item, 'detached', $oldStatus, $newStatus);

			// Set order status OK
			$oldStatus = $order->status;
			$newStatus = Order::STATUS_OK;
			$order->status = $newStatus;
			$order->save();
			$event_order = new OrderStatusChanged($order, 'detached', $oldStatus, $newStatus);

			$this->verifyDirection($this->google);

			// Triger events
			event($event_item);
			event($event_order);
		}
	}
    
    /**
     * Mark first item as next
     */
    public function next()
    {
        // Check if ride has next point
        $next = $this->points()->wherePivotIn('status', [RidePoint::STATUS_NEXT, RidePoint::STATUS_ARRIVED])->first();
        if($next)
        {
            return true;
        }
        
        // Set first active point as next
        $point = $this->points()->wherePivot('status', RidePoint::STATUS_ACTIVE)->first();
        if($point)
        {
            $this->points()->updateExistingPivot($point->getKey(), [
				'status' => RidePoint::STATUS_NEXT,
				'arrive_at' => now()->addSeconds($point->pivot->duration_value)
			]);

            $item = $point->pivot->item;
            if($item){
                $oldStatus = $item->status;
                $newStatus = Item::STATUS_NEXT;

                $item->status = $newStatus;
                $item->arrive_at = now()->addSeconds($point->pivot->duration_value);
                $item->save();

                // Notify *customer
                event(new ItemStatusChanged($item, 'updated', $oldStatus, $newStatus));
				
				if($item->user && ($item->type == Item::TYPE_GO)){
					$delay = 7 * 60; // Notifier 7 minutes avants arriver
					if($point->pivot->duration_value < $delay){
						$item->user->notify((new \App\Notifications\DriverArrived($item, $point->pivot->duration)));
					}else{
						$when = now()->addSeconds($point->pivot->duration_value - 7 * 60);
						$item->user->notify((new \App\Notifications\DriverArrived($item, '7 min'))->delay($when));
					}
				}
            }

            return true;
        }

        
        $oldStatus = $this->status;
        $count = $this->points()->wherePivot('status', '!=', RidePoint::STATUS_CANCELED)->count();
        if($count==0){
            $newStatus = self::STATUS_CANCELABLE;
        }else{
            $newStatus = self::STATUS_COMPLETABLE;
        }

        $this->status = $newStatus;
        $this->save();

        event(new RideStatusChanged($this, 'updated', $oldStatus, $newStatus));

        return false;
    }
    
    /**
     * Check if ride is activable
     */
    public function activable()
    {
        $car = $this->car;
        if($car){
            // Check if car is not disponible
            $active_ride = $car->rides()
                ->where('id', '!=', $this->getKey())
                ->where('status', self::STATUS_ACTIVE)
                ->first();
            if($active_ride){
                return false;
            }
        }
        
        return !in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_CANCELED]);
    }
    
    /**
     * Mark ride as active
     */
    public function active()
    {
        $oldStatus = $this->status;
        $newStatus = self::STATUS_ACTIVE;
        
        $this->status = $newStatus;
        $this->started_at = now();
        $this->save();
        
        // Notify *driver
        event(new RideStatusChanged($this, 'updated', $oldStatus, $newStatus));
        
        // Set all RidePoint as active
        $points = $this->points()->wherePivot('status', RidePoint::STATUS_PING)->get();
        foreach($points as $point){
            $this->points()->updateExistingPivot($point->getKey(), ['status' => RidePoint::STATUS_ACTIVE]);
		}
		
        $items = $this->items()->where('items.status', Item::STATUS_PING)->get();
        foreach($items as $item){
			$oldStatus = $item->status;
			$newStatus = Item::STATUS_ACTIVE;

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
        return !in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_CANCELED]);
    }
    
    /**
     * Cancel ride
     */
    public function cancel()
    {
        $oldStatus = $this->status;
        $newStatus = self::STATUS_CANCELED;
        
        $this->status = $newStatus;
        $this->canceled_at = now();
        $this->save();
    
        event(new RideStatusChanged($this, 'updated', $oldStatus, $newStatus));
        
        // Mark RidePoint NOT COMPLETED as CANCELED
        $points = $this->points()->wherePivotNotIn('status', [RidePoint::STATUS_COMPLETED])->get();
        foreach($points as $point){
            $this->points()->updateExistingPivot($point->getKey(), [
				'status' => RidePoint::STATUS_CANCELED,
				'canceled_at' => now()
			]);
		}
		
		// Mark Item NOT COMPLETED as CANCELED
        $items = $this->items()->whereNotIn('items.status', [Item::STATUS_COMPLETED])->get();
        foreach($items as $item){
			$oldStatus = $item->status;
			$newStatus = Item::STATUS_CANCELED;

			$item->status = $newStatus;
        	$item->canceled_at = now();
			$item->save();

			// Notify *customer
			event(new ItemStatusChanged($item, 'updated', $oldStatus, $newStatus));

			$order = $item->order;
			if($order){
				$oldStatus = $order->status;
				$newStatus = Order::STATUS_CANCELED;
				$order->canceled_at = now();
				$order->status = $newStatus;
				$order->save();

				// Notify *customer
				event(new OrderStatusChanged($order, 'updated', $oldStatus, $newStatus));
			}
        }
    }
    
    /**
     * Check if ride is completable
     */
    public function completable()
    {
        return self::STATUS_COMPLETABLE == $this->status;
    }
    
    /**
     * Complete ride
     */
    public function complete()
    {
        $oldStatus = $this->status;
        $newStatus = self::STATUS_COMPLETED;
        
        $this->status = $newStatus;
        $this->completed_at = now();
        $this->save();
        
		$events = [];
        $events[] = new RideStatusChanged($this, 'updated', $oldStatus, $newStatus);
        
        // Mark RidePoint ONLINE as COMPLETED
        $points = $this->points()->wherePivot('status', RidePoint::STATUS_ONLINE)->get();
        foreach($points as $point){
            $this->points()->updateExistingPivot($point->getKey(), [
				'status' => RidePoint::STATUS_COMPLETED,
				'completed_at' => now()
			]);
		}
		
		$items = $this->items()->where('items.status', Item::STATUS_ONLINE)->get();
		foreach($items as $item){
			$oldStatus = $item->status;
			$newStatus = Item::STATUS_COMPLETED;

			$item->status = $newStatus;
			$item->completed_at = now();
			$item->save();

			// Notify *customer
			$events[] = new ItemStatusChanged($item, 'updated', $oldStatus, $newStatus);

			$order = $item->order;
			if($order){
				$ping_item = $order->items()->whereIn('items.status', [Item::STATUS_PING, Item::STATUS_ACTIVE])->exists();
				if($ping_item){
					$oldStatus = $order->status;
					$newStatus = Order::STATUS_OK;
				}else{
					$oldStatus = $order->status;
					$newStatus = Order::STATUS_COMPLETED;
					$order->completed_at = now();
				}

				$order->status = $newStatus;
				$order->save();

				// Notify *customer
				$events[] = new OrderStatusChanged($order, 'updated', $oldStatus, $newStatus);
			}
        }
		
		foreach($events as $event){
			event($event);
		}
    }
    
    /**
     * Get the order's note.
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }

    /**
     * Calculate direction
     *
     * @Param App\Models\Ride $ride
     * @return mixed
     */
    public function verifyDirection($google)
    {
        $ride = $this;
        
        $car = $ride->car;
        if(!$car){
            return false;
        }
        
        $club = $car->club;
        if(!$club){
            return false;
        }
        
        $clubPoint = $club->point;
        if(!$clubPoint){
            return false;
        }
        
        $points = $ride->points()->wherePivotIn('status', [RidePoint::STATUS_PING, RidePoint::STATUS_ACTIVE, RidePoint::STATUS_NEXT])->get();
        if(empty($points)){
            return false;
        }
        
        $origins = sprintf("%s,%s", $clubPoint->lat, $clubPoint->lng);
        $destinations = sprintf("%s,%s", $clubPoint->lat, $clubPoint->lng);
        
        $array_waypoints = [];
        $array_waypoints[] = 'optimize:true';
        foreach($points as $point){
            $array_waypoints[] = sprintf("%s,%s", $point->lat, $point->lng);
        }
        
        $waypoints = null;
        if(count($array_waypoints)>0){
            $waypoints = implode("|", $array_waypoints);
        }
        
        $direction = $google->getDirection($origins, $destinations, $waypoints);
        
        if($direction && isset($direction['status']) && $direction['status'] == "OK"){
            if(isset($direction['routes'])){
                $routes = $direction['routes'];
                if(is_array($routes) && !empty($routes)){
                    $route = $routes[0];
                    
                    $orders = [];
                    if(isset($route['waypoint_order'])){
                        $orders = $route['waypoint_order'];
                        foreach($orders as $key => $order){
                            if(isset($points[$order])){
                                $point = $points[$order];
                                $ride->points()->updateExistingPivot($point->getKey(), ['order' => $key + 1]);
                            }
                        }
                    }
                    
                    if(isset($route['legs'])){
                        $distance = 0;
                        $duration = 0;
                        $legs = $route['legs'];
                        foreach($legs as $key => $leg){
                            // Calculate distance
                            $leg_distance = 0;
                            if(isset($leg['distance']) && isset($leg['distance']['value'])){
                                $leg_distance = $leg['distance']['value'];
                                $distance += $leg_distance;
                            }
                            $leg_distance_text = null;
                            if(isset($leg['distance']) && isset($leg['distance']['text'])){
                                $leg_distance_text = $leg['distance']['text'];
                            }
                            
                            // Calculate duration
                            $leg_duration = 0;
                            if(isset($leg['duration']) && isset($leg['duration']['value'])){
                                $leg_duration = $leg['duration']['value'];
                                $duration += $leg_duration;
                            }
                            $leg_duration_text = null;
                            if(isset($leg['duration']) && isset($leg['duration']['text'])){
                                $leg_duration_text = $leg['duration']['text'];
                            }
                            
                            // Polyline
							$positions = [];
                            if(isset($leg['steps'])){
                                $steps = $leg['steps'];
                                foreach($steps as $step){
                                    if(isset($step['polyline']) && isset($step['polyline']['points'])){
										$decoded = \App\Services\Polyline::decode($step['polyline']['points']);
                                        $positions = array_merge($positions, $decoded);
                                    }
                                }
                            }
                            $polyline = \App\Services\Polyline::encode($positions);
                            
                            // Update polyline
                            if(is_array($orders)&&isset($orders[$key])){
                                $order = $orders[$key];
                                if(isset($points[$order])){
                                    $point = $points[$order];
                                    $ride->points()->updateExistingPivot($point->getKey(), [
                                        'direction' => $polyline,
                                        'distance_value' => $leg_distance,
                                        'distance' => $leg_distance_text,
                                        'duration_value' => $leg_duration,
                                        'duration' => $leg_duration_text,
                                    ]);
                                }
                            }
                            
                        }
                        
                        $ride->distance = $distance;
                        $ride->duration = $duration;
                    }
                    
                    if(isset($route['overview_polyline']) && isset($route['overview_polyline']['points'])){
                        $ride->direction = $route['overview_polyline']['points'];
                    }
                    
                    $ride->route = $route;
                    return $ride->save();
                }
            }
        }
        
        return false;
    }
    
}
