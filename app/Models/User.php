<?php

namespace App\Models;

use App\Contracts\Auth\MustVerifyPhone;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyPhone
{
    use Notifiable;
    
    use SoftDeletes;

    /**
     * The attributes that are datetime type.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'password',
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
        'phone_verified_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];
    
    /**
     * Get the access log for the user.
     */
    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }
    
    /**
     * Get the tokens for the user.
     */
    public function tokens()
    {
        return $this->hasMany(AccessToken::class)->orderBy('created_at', 'desc');
    }
    
    /**
     * Create user's access token
     */
    public function createToken($token)
    {
        return $this->tokens()->create([
            'scopes' => md5(time()) . $token . md5($token),
            'expires_at' => now()->addDays(15)
        ]);
    }
    
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
        return $this->hasMany(Travel::class);
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
     * Get the orders items for the user.
     */
    public function ordersItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    /**
     * The clubs that belong to the user.
     */
    public function clubs()
    {
        return $this->hasMany(Club::class);
    }
    
    /**
     * The zones that belong to the user.
     */
    public function zones()
    {
        return $this->hasMany(Zone::class);
    }
    
    /**
     * The cars that belong to the user.
     */
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
    
    /**
     * The car types that belong to the user.
     */
    public function carTypes()
    {
        return $this->hasMany(CarType::class);
    }
    
    /**
     * The car brands that belong to the user.
     */
    public function carBrands()
    {
        return $this->hasMany(CarBrand::class);
    }
    
    /**
     * The car models that belong to the user.
     */
    public function carModels()
    {
        return $this->hasMany(CarModel::class);
    }
    
    /**
     * The api keys that creates by the user.
     */
    public function apiKeys()
    {
        return $this->hasMany(ApiKey::class);
    }
    
    /**
     * The points that creates by the user.
     */
    public function points()
    {
        return $this->hasMany(Point::class);
    }
    
    /**
     * The positions that belong to the user.
     */
    public function positions()
    {
        return $this->belongsToMany(Point::class, 'user_positions')->using(UserPosition::class);
    }
    
    /**
     * The roles that created by the user.
     */
    public function createdRoles()
    {
        return $this->hasMany(Role::class);
    }
    
    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->using(RoleUser::class);
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
    * Check if is admin
    *
    * @param string $role
    */
    public function isAdmin()
    {
        return null !== $this->roles()->where('name', Role::ADMIN)->first();
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
     * Route notifications for the Nexmo channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForNexmo($notification)
    {
        return $this->phone;
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
    
    /**
     * Send phone number verification
     *
     * @return string
     */
    public function hasVerifiedPhone()
    {
        return null != $this->phone_verified_at;
    }
    
    /**
     * Mark the given user's phone number as verified.
     *
     * @return bool
     */
    public function markPhoneAsVerified()
    {
        $this->phone_verified_at = now();
        
        return $this->save();
    }

    /**
     * Send the phone verification notification.
     *
     * @return void
     */
    public function sendPhoneVerificationNotification()
    {
        
    }

    /**
     * Get the phone number that should be used for verification.
     *
     * @return string
     */
    public function getPhoneForVerification(){
        return $this->phone;
    }
}
