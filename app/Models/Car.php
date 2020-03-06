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
     * Get the model that owns the car.
     */
    public function model()
    {
        return $this->belongsTo(CarModel::class);
    }
    
    /**
     * Get the travels for the car.
     */
    public function travels()
    {
        return $this->hasMany(Travel::class);
    }
}
