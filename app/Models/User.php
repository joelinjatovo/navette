<?php

namespace App\Models;

use App\Contracts\Auth\MustVerifyPhone;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

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
    ];
    
    /**
     * Get the access log for the user.
     */
    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }
    
    /**
     * The api keys that creates by the user.
     */
    public function apiKeys()
    {
        return $this->hasMany(ApiKey::class);
    }
    
    /**
     * The cars that belong to the user.
     */
    public function cars()
    {
        return $this->hasMany(Car::class);
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
     * The car types that belong to the user.
     */
    public function carTypes()
    {
        return $this->hasMany(CarType::class);
    }
    
    /**
     * Get the orders canceled by the user.
     */
    public function canceledOrders()
    {
        return $this->hasMany(Order::class, 'canceled_by');
    }
    
    /**
     * The clubs that belong to the user.
     */
    public function clubs()
    {
        return $this->hasMany(Club::class);
    }
    
    /**
     * Get the user's image.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    
    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    /**
     * Get the phones for the user.
     */
    public function phones()
    {
        return $this->hasMany(Phone::class);
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
        return $this->belongsToMany(Point::class, 'user_point')->using(UserPoint::class);
    }
    
    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->using(RoleUser::class);
    }
    
    /**
     * The roles that created by the user.
     */
    public function rolesCreated()
    {
        return $this->hasMany(Role::class);
    }
    
    /**
     * Get the travels created by the user.
     */
    public function travelsCreated()
    {
        return $this->hasMany(Travel::class);
    }
    
    /**
     * Get the travels drived by the user.
     */
    public function travelsDrived()
    {
        return $this->hasMany(Travel::class, 'driver_id', 'id');
    }
    
    /**
     * Get the tokens for the user.
     */
    public function tokens()
    {
        return $this->hasMany(AccessToken::class)->orderBy('created_at', 'desc');
    }
    
    /**
     * The zones that belong to the user.
     */
    public function zones()
    {
        return $this->hasMany(Zone::class);
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
    * Check if is admin
    *
    * @param string $role
    */
    public function isAdmin()
    {
        return $this->hasRole(Role::ADMIN);
    }
    
    /**
    * Check if is driver
    *
    * @param string $role
    */
    public function isDriver()
    {
        return $this->hasRole(Role::DRIVER);
    }
    
    /**
    * Check if is customer
    *
    * @param string $role
    */
    public function isCustomer()
    {
        return $this->hasRole(Role::CUSTOMER);
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
        return $this->forceFill([
            'phone_verification_code' => null,
            'phone_verification_expires_at' => null,
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send the phone verification notification.
     *
     * @return void
     */
    public function sendPhoneVerificationNotification()
    {
        $code = "1256";
        
        $this->forceFill([
            'phone_verification_code' => md5($code),
            'phone_verification_expires_at' => Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
        ])->save();
        
        $this->notify(new \App\Notifications\VerifyPhone($code));
    }

    /**
     * Get the phone number that should be used for verification.
     *
     * @return string
     */
    public function isValidCode($code){
        return ( $this->phone_verification_expires_at > now() ) && ( md5($code) == $this->phone_verification_code);
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
