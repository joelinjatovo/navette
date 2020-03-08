<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    
    use SoftDeletes;
    
    /**
     * Get the user that adds the club.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
