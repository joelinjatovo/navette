<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    
    public const TYPE_GO = 'go';
    
    public const TYPE_BACK = 'back';
    
    public const STATUS_PING = 'ping';
    
    public const STATUS_ACTIVE = 'active';
    
    public const STATUS_NEXT = 'next';
    
    public const STATUS_CANCELED = 'canceled';
    
    public const STATUS_COMPLETED = 'completed';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'distance',
        'distance_value',
        'delay',
        'delay_value',
        'direction',
        'rided_at',
    ];
    
    /**
     * Get the driver that owns the order.
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
    
    /**
     * Get the order's note.
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }
    
    /**
     * Get the order that owns the item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    
    /**
     * Get the ride that owns the item.
     */
    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
    }
    
    /**
     * Get the point that owns the item.
     */
    public function point()
    {
        return $this->belongsTo(Point::class);
    }
}
