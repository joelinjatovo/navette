<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
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
        'scopes', 'expires_at'
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
     * Get the refresh that owns the token.
     */
    public function refreshToken()
    {
        return $this->hasOne(RefreshToken::class);
    }
    
    /**
     * Renew scopes
     */
    public function renew($token)
    {
        $this->scopes = md5(time()) . $token . md5($token);
        $this->expires_at = now()->addDays(15);
        $this->save();
    }
    
    /**
     * Create token's refresh token
     */
    public function createRefreshToken($token)
    {
        return $this->refreshToken()->create([
            'scopes' => md5(time()) . $token . md5($token),
            'expires_at' => now()->addDays(30),
            'user_id' => $this->user?$this->user->id:null,
        ]);
    }
    
}
