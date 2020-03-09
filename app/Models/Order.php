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
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'place', 'amount', 'total', 'subtotal', 'currency', 'vat', 'preordered', 'privatized', 'ip_address', 'mac_address',
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
     * Get the first order.
     */
    public function first()
    {
        return $this->belongsTo(Order::class);
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
     * Get the phones that owns the order.
     */
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
    
    /**
     * The points that belong to the order.
     */
    public function points()
    {
        return $this->belongsToMany(Point::class, 'order_point')->using(UserPoint::class);
    }
    
    /**
     * Get second order that owns the first order
     */
    public function second()
    {
        return $this->hasOne(Order::class);
    }
    
    /**
     * Get zone that owns the order
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
