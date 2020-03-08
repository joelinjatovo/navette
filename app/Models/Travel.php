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
        'status',
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
     * Save item author
     */
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->user_id = auth()->check()?auth()->user()->id:null;
        });
    }
    
    /**
     * Get the card associated with the race.
     */
    public function car()
    {
        return $this->hasOne(Car::class);
    }
    
    /**
     * Get the driver associated with the race.
     */
    public function driver()
    {
        return $this->hasOne(User::class, 'driver_id', 'id');
    }
    
    /**
     * Get the orders associated with the travel.
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
        return $this->belongsToMany(Point::class, 'order_point')->using(UserPoint::class);
    }
    
    /**
     * Get the user who creates the travel.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
