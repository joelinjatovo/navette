<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * Get the phones for the user.
     */
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
    
    /**
     * Get the travels for the user.
     */
    public function createdTravels()
    {
        return $this->hasMany(Travel::class, 'author_id', 'id');
    }
    
    /**
     * Get the travels for the user.
     */
    public function drivedTravels()
    {
        return $this->hasMany(Travel::class, 'driver_id', 'id');
    }
    
    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    /**
     * The clubs that belong to the user.
     */
    public function clubs()
    {
        return $this->hasMany(Club::class, 'author_id', 'id');
    }
    
    /**
     * The zones that belong to the user.
     */
    public function zones()
    {
        return $this->hasMany(Zone::class, 'author_id', 'id');
    }
    
    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->using(RoleUser::class);
    }
    
    /**
     * The positions that belong to the user.
     */
    public function positions()
    {
        return $this->belongsToMany(Point::class)->using(UserPosition::class);
    }
    
    /**
    * Check multiple roles
    *
    * @param array $roles
    */
    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }
    
    /**
    * Check one role
    *
    * @param string $role
    */
    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }
    
    /**
    * Check user can join travel
    *
    * @param int $travel_id
    */
    public function canJoinTravel($travel_id)
    {
        return null !== $this->travels()->where('id', $travel_id)->first();
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        // Return name and email address...
        return [$this->email => $this->name];
    }
    
    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'users.'.$this->id;
    }

    /**
     * Route notifications for the Nexmo channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForNexmo($notification)
    {
        return $this->phone_number;
    }
    
    /**
     * Get the user's preferred locale.
     *
     * @return string
     */
    public function preferredLocale()
    {
        return $this->locale;
    }
}
