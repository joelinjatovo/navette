<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scopes', 'user_id', 'expires_at'
    ];
    
    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the token that owns the refresh token.
     */
    public function token()
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
