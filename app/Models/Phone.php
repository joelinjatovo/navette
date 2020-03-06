<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'phone_country_code', 'phone_number', 'phone',
    ];
    
    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the orders that owns the phone.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
