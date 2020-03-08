<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    const ADMIN = 'admin';
    
    const DRIVER = 'driver';
    
    const CUSTOMER = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'priority',
    ];
    
    /**
     * The user that creates the role.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->using(RoleUser::class);
    }
}
