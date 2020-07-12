<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    
    public const STATUS_AVAILABLE = 'available';
	
    public const STATUS_UNAVAILABLE = 'unavailable';
	
    public const STATUS_LOCKED = 'locked';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'name',
        'description',
        'place',
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
     * Get the club that owns the car.
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
    
    /**
     * Get the driver that owns the car.
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
    
    /**
     * 
     */
    public function free()
    {
        $this->status = self::STATUS_AVAILABLE;
		$this->save();
    }
    
    /**
     * Get the car's image.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable')
            ->whereNull('images.type')
            ->orderBy('images.created_at', 'desc');
    }
    
    /**
     * 
     */
    public function lock()
    {
        $this->status = self::STATUS_LOCKED;
		$this->save();
    }
    
    /**
     * Get the user that creates the car.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }
}
