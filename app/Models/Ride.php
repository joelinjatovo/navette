<?php

namespace App\Models;

use App\Events\Ride\RideActived;
use App\Events\Ride\RideCancelable;
use App\Events\Ride\RideCanceled;
use App\Events\Ride\RideCompletable;
use App\Events\Ride\RideCompleted;
use App\Events\Ride\RideCreated;
use App\Events\Ride\RideDeleted;
use App\Events\Ride\RideStarted;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ride extends Model
{
    
    use SoftDeletes;
    
    const STATUS_PING = 'ping';
    
    const STATUS_CANCELABLE = 'cancelable';
    
    const STATUS_CANCELED = 'canceled';
    
    const STATUS_COMPLETABLE = 'completable';
    
    const STATUS_COMPLETED = 'completed';
	
    const STATUS_STARTED = 'started';
    
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
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'cancelable' => RideCancelable::class,
        'canceled' => RideCanceled::class,
        'completable' => RideCompletable::class,
        'completed' => RideCompleted::class,
        'deleted' => RideDeleted::class,
        'started' => RideStarted::class,
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
     * Mark ride as active
     */
    public function active()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->started_at = now();
        $this->save();
		
        $this->fireModelEvent('actived');
    }
    
    /**
     * Attach point to the ride
     */
    public function attachRidePoint(Item $item)
    {
		if($item->point){
			$this->points()
				->attach(
					$item->point->getKey(), 
					[
						'status' => RidePoint::STATUS_PING,
						'type' => Item::TYPE_BACK == $item->type ? RidePoint::TYPE_DROP : RidePoint::TYPE_PICKUP,
						'order' => 0,
						'item_id' => $item->getKey(),
						'user_id' => $item->user ? $item->user->getKey() : null,
					]
				);

			$point = $this->points()->wherePivot('point_id', $item->point->getKey())->first();
			if($point && $point->pivot){
				$point->pivot->fireModelEvent('attached');
			}
			
		}
	}
    
    /**
     * Set ride status as cancelable and fired event
     */
    public function cancelable()
    {
        $this->status = self::STATUS_CANCELABLE;
        $this->save();
		
        $this->fireModelEvent('cancelable');
    }
    
    /**
     * Cancel ride
     */
    public function cancel()
    {
        $this->status = self::STATUS_CANCELED;
        $this->canceled_at = now();
        $this->save();
		
        $this->fireModelEvent('canceled');
    }
    
    /**
     * Get the card associated with the race.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    
    /**
     * Check if ride is completable
     */
    public function completable()
    {
        $this->status = self::STATUS_COMPLETABLE;
        $this->save();

		$this->fireModelEvent('completable');
    }
    
    /**
     * Complete ride
     */
    public function complete()
    {
        $this->status = self::STATUS_COMPLETED;
        $this->completed_at = now();
        $this->save();

		$this->fireModelEvent('completed');
    }
    
    /**
     * Get the driver associated with the race.
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id', 'id')->with('roles');
    }
    
    /**
     * Get or select the next ride point
	 * @return RidePoint
     */
    public function getNextPoint()
    {
        // Check if ride has next point
        $next = $this->points()->wherePivotIn('status', [RidePoint::STATUS_NEXT, RidePoint::STATUS_ARRIVED])->first();
        if($next)
        {
            return $next->pivot;
        }
        
        // Set first active point as next
        $point = $this->points()->wherePivot('status', RidePoint::STATUS_ACTIVE)->first();
        if($point)
        {
            $this->points()->updateExistingPivot($point->getKey(), [
				'status' => RidePoint::STATUS_NEXT,
				'start_at' => now()->addSeconds($point->pivot->duration_value)
			]);
			
			$this->processNext($point->pivot);
			
			return $point->pivot;
        }
		
		$this->updateStatus();
		
        return null;
    }
    
    /**
     * Check if ride is cancelable
	 * @return bool
     */
    public function isCancelable()
    {
		return !in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_CANCELED]);
    }
    
    /**
     * Check if ride is completable
	 * @return bool
     */
    public function isCompletable()
    {
        return self::STATUS_COMPLETABLE == $this->status;
    }
    
    /**
     * Check if ride is startable
	 * @return bool
     */
    public function isStartable()
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
     * Get the items
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
	
    /**
     * Get the order's note.
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
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
						'arrived_at', 
						'start_at',
						'started_at',
						'canceled_at',
						'completed_at',
						'user_id',
						'item_id',
                    ])->orderBy('order', 'asc');
    }
    
    /**
     * Process next ride point
     */
    public function processNext(RidePoint $ridepoint)
    {
		if($ridepoint->item){
			$ridepoint->item->next();
			$ridepoint->item->setStartDate(now()->addSeconds($ridepoint->duration_value));
		}
	}
    
    /**
     * Update status of the ride
     */
    public function updateStatus()
    {
		// Si tous les points sont annulés
        $count = $this->points()->wherePivot('status', '!=', RidePoint::STATUS_CANCELED)->count();
        if($count==0){
			$this->cancelable(); // Set ride as cancelable
        }else{
			$this->completable(); // Set ride as completable
		}
	}
    
    
    /**
     * Get the user who creates the ride.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Start a ride
     */
    public function start()
    {
        $this->status = self::STATUS_STARTED;
        $this->started_at = now();
        $this->save();

		$this->fireModelEvent('started');
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
