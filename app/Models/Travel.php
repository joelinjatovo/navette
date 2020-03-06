<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Travel extends Model
{
    
    use SoftDeletes;
    
    const STATUS_PING = 'ping';
    const STATUS_ACTIVE = 'active';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'status',
    ];

    /**
     * The attributes that are datetime type.
     *
     * @var array
     */
    protected $dates = [
        'started_at', 'arrived_at', 'returned_at', 'created_at', 'updated_at', 'deleted_at',
    ];
    
    /**
     * Get the driver associated with the race.
     */
    public function driver()
    {
        return $this->hasOne(User::class, 'driver_id', 'id');
    }
    
    /**
     * Get the author associated with the race.
     */
    public function author()
    {
        return $this->hasOne(User::class, 'author_id', 'id');
    }
    
    /**
     * Get the card associated with the race.
     */
    public function car()
    {
        return $this->hasOne(Car::class);
    }
    
    /**
     * Get the parent that owns the travel.
     */
    public function travel()
    {
        return $this->belongsTo(Travel::class, 'parent_id', 'id');
    }

    /**
     * Get the childs travels associated with travel.
     */
    public function items()
    {
        return $this->hasMany(Travel::class, 'parent_id', 'id');
    }

    /**
     * Get the orders associated with the travel.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the order items associated with the travel.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    /**
     * Get the start point that owns the travel.
     */
    public function startPoint()
    {
        return $this->belongsTo(Point::class, 'start_point_id', 'id');
    }
    
    /**
     * Get the arrival point that owns the travel.
     */
    public function arrivalPoint()
    {
        return $this->belongsTo(Point::class, 'arrival_point_id', 'id');
    }
    
    /**
     * Get the return point that owns the travel.
     */
    public function returnPoint()
    {
        return $this->belongsTo(Point::class, 'return_point_id', 'id');
    }
}
