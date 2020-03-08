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
     * Get the clubs what owns the point.
     */
    public function clubs()
    {
        return $this->hasMany(Club::class);
    }
    
    /**
     * The orders that belong to the point.
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_point')->using(OrderPoint::class);
    }
    
    /**
     * The travels that belong to the point.
     */
    public function travels()
    {
        return $this->belongsToMany(Travel::class, 'travel_point')->using(TravelPoint::class);
    }

    /**
     * Get the user what creates the point.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * The users that belong to the point.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_point')->using(UserPoint::class);
    }
}
