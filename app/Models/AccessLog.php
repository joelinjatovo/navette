<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{

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
        'user_id', 'url', 'referer', 'user_agent', 'ip', 'country', 'platform', 'api', 'api_key_id'
    ];
    
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
