<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ride extends Model
{
    
    use SoftDeletes;
    
    const STATUS_PING = 'ping';
    
    const STATUS_STARTED = 'started';
    
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
     * Get the orders associated with the ride.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    /**
     * The points that belong to the order.
     */
    public function points()
    {
        return $this->belongsToMany(Point::class, 'ride_point')
                    ->using(RidePoint::class)
                    ->withPivot([
                        'status', 
                        'type', 
                        'order'
                    ]);
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
        $this->status = self::STATUS_STARTED;
        $this->started_at = now();
        $this->save();
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
    
}
