<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    
    use SoftDeletes;

    /**
     * The attributes that are datetime type.
     *
     * @var array
     */
    protected $dates = [
        'attached_at', 'canceled_at', 'detached_at', 'started_at', 'arrived_at', 'returned_at', 'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'place', 'price', 'total', 'currency', 'vat', 'preordered', 'privatized', 'contact_name', 'contact_email', 'ip', 'mac',
    ];
    
    /**
     * Get the car that owns the order.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    
    /**
     * Get the user that owns the order.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    /**
     * Get the travel that owns the order.
     */
    public function travel()
    {
        return $this->belongsTo(Travel::class);
    }
    
    /**
     * Get the phone that owns the order.
     */
    public function phone()
    {
        return $this->belongsTo(Phone::class);
    }

    /**
     * Get the items associated with the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    /**
     * Get the start point that owns the order item.
     */
    public function startPoint()
    {
        return $this->belongsTo(Point::class, 'start_point_id', 'id');
    }
    
    /**
     * Get the arrival point that owns the order item.
     */
    public function arrivalPoint()
    {
        return $this->belongsTo(Point::class, 'arrival_point_id', 'id');
    }
    
    /**
     * Get the return point that owns the order item.
     */
    public function returnPoint()
    {
        return $this->belongsTo(Point::class, 'return_point_id', 'id');
    }
}
