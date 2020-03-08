<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Model
{
    
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
    
    /**
     * Get the point that owns the club.
     */
    public function point()
    {
        return $this->belongsTo(Point::class);
    }
    
    /**
     * Get the user that adds the club.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
