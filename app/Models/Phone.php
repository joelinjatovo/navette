<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    const TYPE_HOME = 'home';
    const TYPE_WORK = 'work';
    const TYPE_MOBILE = 'mobile';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type' => self::TYPE_HOME
    ];
    
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
     * Get the order that owns the phone.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
