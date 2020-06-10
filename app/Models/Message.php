<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

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
     * Get the owning messageable model.
     */
    public function messageable()
    {
        return $this->morphTo();
    }
    
    /**
     * Get the user that adds the message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
