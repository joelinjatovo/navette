<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
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
     * Save item author
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
     * Get the user that adds the car brand.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * The models that belong to the car brand.
     */
    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
}
