<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{

	const TYPE_REVIEWS = 'reviews';
	
	const TYPE_AVG = 'avg';
	
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
     * Get the owning notable model.
     */
    public function notable()
    {
        return $this->morphTo();
    }
    
    /**
     * Get the user that adds the club.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
