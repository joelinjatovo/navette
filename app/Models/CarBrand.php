<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    /**
     * The models that belong to the car brand.
     */
    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
}
