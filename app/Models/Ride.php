<?php

namespace App\Models;

use App\Events\RideStatusChanged;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ride extends Model
{
    
    use SoftDeletes;
    
    const STATUS_PING = 'ping';
    
    const STATUS_ACTIVE = 'active';
    
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
     * Check if ride is startable
     */
    public function startable()
    {
        return self::STATUS_COMPLETED != $this->status;
    }
    
    /**
     * Mark ride as started
     */
    public function start()
    {
        $oldStatus = $this->status;
        $newStatus = self::STATUS_ACTIVE;
        $this->status = $newStatus;
        $this->started_at = now();
        $this->save();
        
        event(new RideStatusChanged($this, 'started', $oldStatus, $newStatus));
    }
    
    /**
     * Check if order is cancelable
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
        $this->status = self::STATUS_CANCELED;
        $this->canceled_at = now();
        $this->save();
    }
    
    /**
     * Complete ride
     */
    public function complete()
    {
        $this->status = self::STATUS_COMPLETED;
        $this->completed_at = now();
        $this->save();
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
        
        $points = $ride->points()->wherePivot('status', 'active')->get();
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
                        $delay = 0;
                        $legs = $route['legs'];
                        foreach($legs as $leg){
                            if(isset($leg['distance']) && isset($leg['distance']['value'])){
                                $distance += $leg['distance']['value'];
                            }
                            if(isset($leg['duration']) && isset($leg['duration']['value'])){
                                $delay += $leg['duration']['value'];
                            }
                        }
                        
                        $ride->distance = $distance;
                        $ride->delay = $delay;
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
