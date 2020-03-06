<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token', 'refresh_token',
    ];
    
    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
