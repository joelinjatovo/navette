<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AccessToken extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scopes'
    ];
    
    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Renew scopes
     */
    public function renew($token)
    {
        $this->scopes = Hash::make($token, ['rounds' => 11]);
        $this->expires_at = now()->addDays(15);
        $this->save();
    }
    
    /**
     * Get the refresh that owns the token.
     */
    public function refresh()
    {
        return $this->hasOne(RefreshToken::class);
    }
    
    /**
     * Create token's refresh token
     */
    public function createRefreshToken($token)
    {
        return $this->refresh()->create([
            'scopes' => Hash::make($token, ['rounds' => 27]),
            'expires_at' => now()->addDays(30),
            'user_id' => $this->user()?$this->user()->id:null
        ]);
    }
    
}
