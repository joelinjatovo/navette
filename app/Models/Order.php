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
        'assigned_at', 'actived_at', 'canceled_at', 'moved_at', 'finished_at', 'started_at', 'arrived_at', 'returned_at', 'created_at', 'updated_at', 'deleted_at',
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
     * Check if order is assigned
     * @return boolean
     */
    public function isAssigned()
    {
        return ! is_null($this->assigned_at);
    }
    
    /**
     * Check if order is actived
     * @return boolean
     */
    public function isActived()
    {
        return ! is_null($this->actived_at);
    }
    
    /**
     * Check if order is canceled
     * @return boolean
     */
    public function isCanceled()
    {
        return ! is_null($this->canceled_at);
    }
    
    /**
     * Check if order is moved
     * @return boolean
     */
    public function isMoved()
    {
        return ! is_null($this->moved_at);
    }
    
    /**
     * Check if order is finished
     * @return boolean
     */
    public function isFinished()
    {
        return ! is_null($this->finished_at);
    }
    
    /**
     * Check if order is started
     * @return boolean
     */
    public function isStarted()
    {
        return ! is_null($this->started_at);
    }
    
    /**
     * Check if order is arrived
     * @return boolean
     */
    public function isArrived()
    {
        return ! is_null($this->arrived_at);
    }
    
    /**
     * Check if order is returned
     * @return boolean
     */
    public function isReturned()
    {
        return ! is_null($this->returned_at);
    }
    
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
    public function user()
    {
        return $this->belongsTo(User::class);
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
