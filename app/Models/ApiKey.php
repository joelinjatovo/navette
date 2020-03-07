<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{

    /**
     * The attributes that are datetime type.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'expires_at',
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'scopes', 'version', 'user_agent', 'revoked', 'expires_at',
    ];
    
    /**
     * Get the access log for the api key.
     */
    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }
}
