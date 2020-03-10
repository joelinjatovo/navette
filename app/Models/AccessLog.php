<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AccessLog extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are datetime type.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'status',  'url', 'referer', 'user_agent', 'ip', 'country', 'platform', 'api', 'api_key_id'
    ];

    /**
     * Save item author
     */
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if ( empty( $model->{$model->getKeyName()} ) ) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
            if( empty( $model->user_id ) && auth()->check() ) {
                $model->user_id = auth()->user()->id;
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
    
    /**
     * Get the Api Key that owns the phone.
     */
    public function api()
    {
        return $this->belongsTo(ApiKey::class, 'api_key_id', 'id');
    }
}
