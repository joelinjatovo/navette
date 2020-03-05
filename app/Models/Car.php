<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    
    /**
     * Get the model that owns the car.
     */
    public function model()
    {
        return $this->belongsTo(CarModel::class);
    }
    
    /**
     * Get the races for the car.
     */
    public function races()
    {
        return $this->hasMany(Race::class);
    }
}
