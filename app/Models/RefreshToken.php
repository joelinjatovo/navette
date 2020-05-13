<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RefreshToken extends Model
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scopes', 'user_id', 'expires_at'
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
            if ( empty( $model->{$model->getKeyName()} ) ) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
            if( empty( $model->user_id ) && $model->accessToken && $model->accessToken->user ) {
                $model->user_id = $model->accessToken->user->id;
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
     * Get the Access Token that owns the refresh token.
     */
    public function accessToken()
    {
        return $this->belongsTo(AccessToken::class);
    }
    
    /**
     * Renew scopes
     */
    public function renew()
    {
        $this->expires_at = now()->addDays(30);
        $this->save();
    }
}
