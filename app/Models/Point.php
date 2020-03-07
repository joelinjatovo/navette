<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'long', 'lat', 'alt',
    ];

    /**
     * The attributes that are datetime type.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at',
    ];

    /**
     * Get the clubs what owns the point.
     */
    public function clubs()
    {
        return $this->hasMany(Club::class);
    }

    /**
     * Get the travels who starts at the point.
     */
    public function starts($type = null)
    {
        switch(strtolower($type)){
            case 'order': 
                return $this->hasMany(Order::class, 'start_point_id', 'id');
            case 'order-item': 
                return $this->hasMany(OrderItem::class, 'start_point_id', 'id');
            case 'travel':
            default: 
                return $this->hasMany(Travel::class, 'start_point_id', 'id');
        }
    }

    /**
     * Get the travels who arrives at the point.
     */
    public function arrivals($type = null)
    {
        switch(strtolower($type)){
            case 'order': 
                return $this->hasMany(Order::class, 'arrival_point_id', 'id');
            case 'order-item': 
                return $this->hasMany(OrderItem::class, 'arrival_point_id', 'id');
            case 'travel':
            default: 
                return $this->hasMany(Travel::class, 'arrival_point_id', 'id');
        }
    }

    /**
     * Get the travels who returns at the point.
     */
    public function returns($type = null)
    {
        switch(strtolower($type)){
            case 'order': 
                return $this->hasMany(Order::class, 'return_point_id', 'id');
            case 'order-item': 
                return $this->hasMany(OrderItem::class, 'return_point_id', 'id');
            case 'travel':
            default: 
                return $this->hasMany(Travel::class, 'return_point_id', 'id');
        }
    }
    
    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_positions')->using(UserPosition::class);
    }
}
