<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
    
    /**
     * The models that belong to the car type.
     */
    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
}
