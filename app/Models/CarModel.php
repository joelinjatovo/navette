<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
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
     * Get the user that adds the car model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the type that owns the car model.
     */
    public function type()
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }
    
    /**
     * Get the brand that owns the car model.
     */
    public function brand()
    {
        return $this->belongsTo(CarBrand::class, 'car_brand_id');
    }
    
    /**
     * The cars that belong to the model.
     */
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
