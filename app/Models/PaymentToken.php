<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentToken extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_type',
        'amount',
        'currency',
        'order_id',
        'token',
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
