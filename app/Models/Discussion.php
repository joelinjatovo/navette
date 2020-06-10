<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

class Discussion extends Pivot
{  
    /**
     * 
     */
    public function user1()
    {
        return $this->belongsTo(User::class, 'user_1_id');
    }
    
    /**
     * 
     */
    public function user2()
    {
        return $this->belongsTo(User::class, 'user_2_id');
    }
	
    /**
     * Get the ride items's chat message.
     */
    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }
}
