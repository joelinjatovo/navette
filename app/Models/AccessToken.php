<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scopes', 'expires_at'
    ];

    /**
     * Save item author
     */
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->user_id = auth()->check()?auth()->user()->id:null;
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
