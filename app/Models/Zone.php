<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{

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
     * Get the user that adds the zone.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the orders that adds the zone.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    /**
     * Find zone by distance
     */
    public static function findByDistance($distance)
    {
        return Zone::where('distance', '>=', $distance)
                ->orderBy('distance', 'ASC')
                ->first();
    }
}
