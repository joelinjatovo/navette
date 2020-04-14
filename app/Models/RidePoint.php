<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

class RidePoint extends Pivot
{
    
    const TYPE_UP = 'up';
    
    const TYPE_DOWN = 'down';
    
    const STATUS_PING = 'ping';
    
    const STATUS_NEXT = 'next';
    
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
     * Get the user related to this point.
     */
    public function user()
    {
        if($this->point){
            $orders = $this->point->orders;
            if(is_array($orders) && isset($orders[0])){
                return $orders[0]->user();
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
}
