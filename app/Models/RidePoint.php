<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

class RidePoint extends Pivot
{
    
    const TYPE_PICKUP = 'pickup';
    
    const TYPE_DROP = 'drop';
    
    const STATUS_PING = 'ping';
    
    const STATUS_ACTIVE = 'active';
    
    const STATUS_NEXT = 'next';
    
    const STATUS_ONLINE = 'online';
    
    const STATUS_COMPLETED = 'completed';
    
    const STATUS_CANCELED = 'canceled';
    
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if ( empty( $model->{$model->getKeyName()} ) ) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    
    /**
     * Get the item related to this point.
     */
    public function item()
    {
        if($this->point){
            return $this->point->items()->first();
        }
        
        return null;
    }
    
    /**
     * Get the order related to this point.
     */
    public function order()
    {
        if($this->point){
            $item = $this->point->items()->first();
            if($item){
                return $item->order;
            }
        }
        
        return null;
    }
    
    /**
     * Get the user related to this point.
     */
    public function user()
    {
        if($this->point){
            $item = $this->point->items()->first();
            if($item && ($order = $item->order)){
                return $order->user;
            }
        }
        
        return null;
    }
    
    /**
     * Get the point related to this ride point.
     */
    public function point()
    {
        return $this->belongsTo(Point::class, 'point_id');
    }
    
    /**
     * Get the ride related to this ride point.
     */
    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
    }
}
