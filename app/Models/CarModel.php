<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    /**
     * Get the type that owns the car model.
     */
    public function type()
    {
        return $this->belongsTo(CarType::class);
    }
    
    /**
     * Get the brand that owns the car model.
     */
    public function brand()
    {
        return $this->belongsTo(CarBrand::class);
    }
    
    /**
     * The cars that belong to the model.
     */
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
