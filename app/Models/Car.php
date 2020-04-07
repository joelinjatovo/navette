<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'year', 'place',
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
     * Get the club that owns the car.
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
    
    /**
     * Get the car's image.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    
    /**
     * Get the model that owns the car.
     */
    public function model()
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }
    
    /**
     * Get the rides for the car.
     */
    public function rides()
    {
        return $this->hasMany(Ride::class);
    }
    
    /**
     * Get the orders for the car.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    /**
     * Get the user that creates the car.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
