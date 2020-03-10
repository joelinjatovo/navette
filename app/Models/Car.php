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
    
    /**
     * Get the user that creates the car.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
