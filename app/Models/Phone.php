<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    const TYPE_HOME = 'home';
    
    const TYPE_WORK = 'work';
    
    const TYPE_MOBILE = 'mobile';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type' => self::TYPE_HOME
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'phone_country_code', 'phone_number', 'phone',
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
            if( empty( $model->phone ) ) {
                $model->phone = $model->phone_country_code . $model->phone_number;
            }
        });
        
        static::updating(function ($model) {
            if( empty( $model->phone ) ) {
                $model->phone = $model->phone_country_code . $model->phone_number;
            }
        });
    }
    
    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
