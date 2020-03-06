<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class OrderItem extends Model
{
    
    use SoftDeletingTrait;

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
        'status', 'place', 'price', 'total', 'vat', 'preordered', 'privatized',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '',
    ];
    
    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    /**
     * Get the travel that owns the order item.
     */
    public function travel()
    {
        return $this->belongsTo(Travel::class);
    }
    
    /**
     * Get the car that owns the order item.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    
    /**
     * Get the user that owns the order item.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
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
