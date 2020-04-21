<?php

namespace App\Models;

use App\Events\ItemStatusChanged;
use App\Events\RideStatusChanged;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ride extends Model
{
    
    use SoftDeletes;
    
    const STATUS_PING = 'ping';
    
    const STATUS_ACTIVE = 'active';
    
    const STATUS_COMPLETABLE = 'completable';
    
    const STATUS_COMPLETED = 'completed';
    
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
        'created_at', 'updated_at', 'deleted_at',
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
        return $this->belongsTo(User::class, 'driver_id', 'id');
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
                        'order'
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
     * Mark first item as next
     */
    public function next()
    {
        // Check if ride has next point
        $next = $this->points()->where('status', RidePoint::STATUS_NEXT)->first();
        if($next)
        {
            return true;
        }
        
        // Set first active point as next
        $point = $this->points()->where('status', RidePoint::STATUS_ACTIVE)->first();
        if($point)
        {
            $this->points()->updateExistingPivot($point->getKey(), ['status' => RidePoint::STATUS_NEXT]);

            $item = $point->pivot->item();
            if($item){
                $oldStatus = $item->status;
                $newStatus = Item::STATUS_NEXT;

                $item->status = $newStatus;
                $item->save();

                // Notify *customer
                event(new ItemStatusChanged($item, 'updated', $oldStatus, $newStatus));
            }

            return true;
        }

        $oldStatus = $this->status;
        $newStatus = self::STATUS_COMPLETABLE;

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
            
            $item = $point->pivot->item();
            if($item){
                $oldStatus = $item->status;
                $newStatus = Item::STATUS_ACTIVE;
                
                $item->status = $newStatus;
                $item->save();
                
                // Notify *customer
                event(new ItemStatusChanged($item, 'updated', $oldStatus, $newStatus));
            }
        }
    }
    
    /**
     * Check if ride is cancelable
     */
    public function cancelable()
    {
        return self::STATUS_COMPLETED != $this->status;
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
        $points = $this->points()->wherePivotNot('status', RidePoint::STATUS_COMPLETED)->get();
        foreach($points as $point){
            $this->points()->updateExistingPivot($point->getKey(), ['status' => RidePoint::STATUS_CANCELED]);
            
            $item = $point->pivot->item();
            if($item){
                $oldStatus = $item->status;
                $newStatus = Item::STATUS_CANCELED;
                
                $item->status = $newStatus;
                $item->save();
                
                // Notify *customer
                event(new ItemStatusChanged($item, 'updated', $oldStatus, $newStatus));
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
        
        event(new RideStatusChanged($this, 'updated', $oldStatus, $newStatus));
        
        // Mark RidePoint ONLINE as COMPLETED
        $points = $this->points()->wherePivot('status', RidePoint::STATUS_ONLINE)->get();
        foreach($points as $point){
            $this->points()->updateExistingPivot($point->getKey(), ['status' => RidePoint::STATUS_COMPLETED]);
            
            $item = $point->pivot->item();
            if($item){
                $oldStatus = $item->status;
                $newStatus = Item::STATUS_COMPLETED;
                
                $item->status = $newStatus;
                $item->save();
                
                // Notify *customer
                event(new ItemStatusChanged($item, 'updated', $oldStatus, $newStatus));
            }
        }
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
        
        $points = $ride->points()->wherePivotIn('status', [RidePoint::STATUS_ACTIVE, RidePoint::STATUS_NEXT])->get();
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
                            
                            // Calculate duration
                            $leg_duration = 0;
                            if(isset($leg['duration']) && isset($leg['duration']['value'])){
                                $leg_duration = $leg['duration']['value'];
                                $duration += $leg_duration;
                            }
                            
                            // Update polyline
                            if(isset($leg['polyline']) && isset($leg['polyline']['points'])){
                                $polyline = $leg['polyline']['points'];
                                if(is_array($orders)&&isset($orders[$key])){
                                    $order = $orders[$key];
                                    if(isset($points[$order])){
                                        $point = $points[$order];
                                        $ride->points()->updateExistingPivot($point->getKey(), [
                                            'direction' => $polyline,
                                            'distance' => $leg_distance,
                                            'duration' => $leg_duration,
                                        ]);
                                    }
                                }
                            }
                            
                        }
                        
                        $ride->distance = $distance;
                        $ride->duration = $duration;
                    }
                    
                    if(isset($route['overview_polyline']) && isset($route['overview_polyline']['points'])){
                        $ride->direction = $route['overview_polyline']['points'];
                    }
                    
                    return $ride->save();
                }
            }
        }
        
        return false;
    }
    
}
