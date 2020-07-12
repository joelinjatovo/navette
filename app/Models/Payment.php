<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    
    public const STATUS_PING = 'ping';
    
    public const STATUS_FAILED = 'failed';
    
    public const STATUS_SUCCESS = 'success';
    
    public const STATUS_AUTH_REQUIRED = 'auth_required';
	
	public const STATUS_CANCELED = 'canceled';
	
	public const STATUS_REFUNDED = 'refunded';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_type',
        'payment_id',
        'amount',
        'currency',
        'order_id',
    ];
    
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
     * Get the user that creates the payment token.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the user that owns the payment token.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
