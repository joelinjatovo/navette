<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    /**
     * The models that belong to the car type.
     */
    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
}
