<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
		'description'
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
     * Get the cars for the club
     */
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
    
    /**
     * Get the club's car max place
     */
    public function getMaxCarPlace()
    {
        if($this->max_car_place > 0){
            return $this->max_car_place;
        }
        
        return $this->cars()->where('cars.status', '!=', Car::STATUS_UNAVAILABLE)->max('cars.place');
    }
    
    /**
     * Get the club's image.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable')
            ->whereNull('images.type')
            ->orderBy('images.created_at', 'desc');
    }
    
    /**
     * Get the order's note.
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }
    
    /**
     * Get the orders for the club
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    /**
     * Get the order items for the club
     */
    public function items()
    {
        return $this->hasManyThrough(
            Item::class, 
            Order::class,
            'club_id', // Foreign key on orders table...
            'order_id', // Foreign key on items table...
            'id', // Local key on clubs table...
            'id' // Local key on orders table...
        );
    }
    
    /**
     * Get the point that owns the club.
     */
    public function point()
    {
        return $this->belongsTo(Point::class);
    }
    
    /**
     * Get the rides for the club
     */
    public function rides()
    {
        return $this->hasMany(Ride::class);
    }
    
    /**
     * Get the user that adds the club.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
