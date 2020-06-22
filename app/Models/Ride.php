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
use App\Events\Ride\RideStartDelayed;
use App\Events\Ride\RideStartForwarded;
use App\Events\Ride\RideStartInited;
use App\Events\Ride\RideStartRefreshed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ride extends Model
{
    
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
        'created_at', 'updated_at', 'start_at', 'started_at', 'canceled_at', 'complete_at',, 'completed_at', 'deleted_at',
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
        'start-delayed' => RideStartDelayed::class,
        'start-forwarded' => RideStartForwarded::class,
        'start-inited' => RideStartInited::class,
        'start-refreshed' => RideStartRefreshed::class,
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
     * 
     */
    public function attachItem(Item $item, $place)
    {
		$this->items()->attach($item->getKey(), [
			'type' => $item->type == Item::TYPE_BACK ? RideItem::TYPE_DROP : RideItem::TYPE_PICKUP,
			'status' => RideItem::STATUS_PING,
			'place' => $place
		]);
    }
    
    /**
     * 
     */
    public function addPlace($place)
    {
		$this->current_place += $place;
		$this->available_place -= $place;
		$this->save();
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
     * Get the club associated with the race.
     */
    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id', 'id');
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
     * 
     */
    public function delayAfter(Ride $prev, $date)
    {
        $this->setStartDate($date);
        $this->updateTimeWidows();
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
	 * @return RideItem
     */
    public function getNextRideItem()
    {
        // Check if ride has next point
        $rideitem = $this->rideitems()
			->whereIn('status', [RideItem::STATUS_NEXT, RideItem::STATUS_ARRIVED])
			->first();
        if($rideitem){
            return $rideitem;
        }
        
        // Set first active point as next
        $rideitem = $this->rideitems()
			->where('status', [RideItem::STATUS_OK, RideItem::STATUS_ACTIVE])
			->orderBy('order', 'asc')
			->first();
        if($rideitem)
        {
			$rideitem->status = RideItem::STATUS_NEXT;
			$rideitem->start_at = now()->addSeconds($rideitem->duration_value);
			$rideitem->save();
			
			return $rideitem;
        }
		
		// S'il n'y a plus de point suivant
        $all_count = $this->rideitems()->count();
        $canceled_count = $this->rideitems()->where('status', '==', RideItem::STATUS_CANCELED)->count();
        if($all_count == $canceled_count){
			$this->cancelable(); // Set ride as cancelable
        }else{
			$this->completable(); // Set ride as completable
		}
		
        return null;
    }
    
    /**
     * Check if ride has available place
	 * @return bool
     */
    public function hasAvailablePlace($place)
    {
		return $this->avalaible_place >= $place;
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
     * Check if ride is ping
	 * @return bool
     */
    public function isPing()
    {
        return self::STATUS_PING == $this->status;
    }
    
    /**
     * Check if ride is startable
	 * @return bool
     */
    public function isStartable()
    {
        $driver = $this->driver;
        if($driver){
            // Check if car is not disponible
            $hasActiveRide = $driver->ridesDrived()
                ->where('rides.id', '!=', $this->getKey())
                ->where('rides.status', self::STATUS_STARTED)
                ->exists();
            if($hasActiveRide){
                return false;
            }
        }
        
        return !in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_CANCELED]);
    }
    
    /**
     * The items that belong to the order.
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'ride_item')
                    ->using(RideItem::class)
                    ->withPivot([
                        'id', 
                        'status', 
                        'place', 
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
                    ])->orderBy('order', 'asc');
    }
	
    /**
     * Get the ride's chat message.
     */
    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }
	
    /**
     * Get the order's note.
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }
    
    /**
     * Get the club point
     */
    public function point()
    {
    	return $this->club ? $this->club->point : null;
    }
    
    /**
     * Get the ride items that owns the ride.
     */
    public function rideitems()
    {
        return $this->hasMany(RideItem::class, 'ride_id')->with('item');
    }
    
    /**
     * Get the user who creates the ride.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Start the order item
     */
    public function setEndDate($date)
    {
		if($date==null){
			$this->complete_at = null;
			$this->save();
			$this->fireModelEvent('end-refreshed');
			return;
		}
		
		if($this->complete_at){
			if($model->complete_at->greaterThan($date)){
				$this->complete_at = $date;
        		$this->save();
				$this->fireModelEvent('end-delayed');
			}else{
				$this->complete_at = $date;
        		$this->save();
				$this->fireModelEvent('end-forwarded');
			}
		}else{
			$this->complete_at = $date;
        	$this->save();
			$this->fireModelEvent('end-inited');
		}
    }
    
    /**
     * Start the order item
     */
    public function setStartDate($date)
    {
		if($date==null){
			$this->start_at = null;
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
     * Update time intervalle
     *
     * @return mixed
     */
    public function updateTimeWidows()
    {
        // @TODO
    }

    /**
     * Calculate direction
     *
     * @Param App\Models\Ride $ride
     * @return mixed
     */
    public function verifyDirection($google)
    {
		// Check if club has point
		if(!$this->point()){ 
			return false;
        }
		
		$query = $this->rideitems()
			->where(function($query){
				$query->where('type', RideItem::TYPE_PICKUP);
				$query->whereIn('status', [
					RideItem::STATUS_OK, 
					RideItem::STATUS_ACTIVE
				]);
			})
			->orWhere(function($query){
				$query->where('type', RideItem::TYPE_DROP);
				$query->whereIn('status', [
					RideItem::STATUS_OK,
					RideItem::STATUS_ACTIVE,
					RideItem::STATUS_STARTED
				]);
			})
			;
		
		if(!$query->exists()){
			return false;
		}
		
		$rideitems = $query->get();
        
        $origins = sprintf("%s,%s", $this->point()->lat, $this->point()->lng);
        $destinations = sprintf("%s,%s", $this->point()->lat, $this->point()->lng);
        
        $array_waypoints = ['optimize:true'];
        foreach($rideitems as $rideitem){
			// Check if has item point
			if($rideitem->point()){
				$array_waypoints[] = sprintf("%s,%s", $rideitem->point()->lat, $rideitem->point()->lng);
			}
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
                    
					/**
					* Update RideItem order
					*/
                    $orders = [];
                    if(isset($route['waypoint_order'])){
                        $orders = $route['waypoint_order'];
                        foreach($orders as $key => $order){
                            if(isset($rideitems[$order])){
                                $rideitem = $rideitems[$order];
								$rideitem->order = $key + 1;
								$rideitem->save();
                            }
                        }
                    }
                    
					/**
					* Update RideItem course info
					*/
                    if(isset($route['legs'])){
                        $distance = 0;
                        $duration = 0;
                        $legs = $route['legs'];
                        foreach($legs as $key => $leg){
                            $leg_distance = 0;
                            if(isset($leg['distance']) && isset($leg['distance']['value'])){
                                $leg_distance = $leg['distance']['value'];
                                $distance += $leg_distance; // Calculate ride distance
                            }
							
                            $leg_distance_text = null;
                            if(isset($leg['distance']) && isset($leg['distance']['text'])){
                                $leg_distance_text = $leg['distance']['text'];
                            }
                            
                            $leg_duration = 0;
                            if(isset($leg['duration']) && isset($leg['duration']['value'])){
                                $leg_duration = $leg['duration']['value'];
                                $duration += $leg_duration; // Calculate ride duration
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
                            
                            /**
							* Set RideItem info
							*/
                            if( is_array($orders) && isset($orders[$key]) && isset($rideitems[$orders[$key]]) ) {
								$rideitem = $rideitems[$orders[$key]];
								$rideitem->direction = $polyline;
								$rideitem->distance = $leg_distance_text;
								$rideitem->distance_value = $leg_distance;
								$rideitem->duration_value = $leg_duration;
								$rideitem->duration = $leg_duration_text;
								$rideitem->save();
                            }
                        }
                        
                        $this->distance_value = $distance;
                        $this->duration_value = $duration;
                    }
                    
                    if(isset($route['overview_polyline']) && isset($route['overview_polyline']['points'])){
                        $this->direction = $route['overview_polyline']['points'];
                    }
                    
                    $this->route = $route;
				
                    return $this->save();
                }
            }
        }
        
        return false;
    }
   
}