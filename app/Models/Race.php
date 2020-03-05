<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Race extends Model
{

    const TYPE_MAIN = 'main';
    
    const TYPE_CHILD = 'child';
    
    use SoftDeletingTrait;

    /**
     * The attributes that are datetime type.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at','deleted_at',
    ];
    
    /**
     * Get the driver record associated with the race.
     */
    public function driver()
    {
        return $this->hasOne(User::class);
    }
    
    /**
     * Get the card associated with the race.
     */
    public function car()
    {
        return $this->hasOne(Car::class);
    }
    
    /**
     * Get the race associated with the child race.
     */
    public function parent()
    {
        return $this->belongsTo(Race::class, 'parent_id');
    }

    /**
     * Get the childs race associated with the parent race.
     */
    public function childs()
    {
        return $this->hasMany(Race::class, 'parent_id');
    }
}
