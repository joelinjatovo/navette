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
        'stripe_id', 
		'facebook_id', 
		'payment_method_id', 
		'first_name', 
		'last_name', 
		'birthday', 
		'address', 
		'postal_code', 
		'name', 
		'email', 
		'phone', 
		'password',
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
        'activated_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if ( empty( $model->code ) ) {
                $model->code = (string) \Str::random(6);
            }
            $model->name = $model->first_name . ' ' . $model->last_name;
        });
        
        static::updating(function ($model) {
            $model->name = $model->first_name . ' ' . $model->last_name;
        });
    }
    
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
        return $this->hasMany(Car::class, 'user_id');
    }
    
    /**
     * Check if user can pay per cash
     */
    public function canPayPerCash()
    {
        return true;
    }
    
    /**
     * The cars drived that belong to the user.
     */
    public function car()
    {
        return $this->hasOne(Car::class, 'driver_id');
    }
    
    /**
     * Get the orders canceled by the user.
     */
    public function canceledOrders()
    {
        return $this->hasMany(Order::class, 'canceler_id');
    }
    
    /**
     * Get parent children
     */
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
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
        return $this->morphOne(Image::class, 'imageable')
            ->whereNull('images.type')
            ->orderBy('images.created_at', 'desc');
    }
    
    /**
     * Get the user's image.
     */
    public function isActivated()
    {
        return $this->activated_at!=null;
    }
    
    /**
     * Get the driver's license recto.
     */
    public function licenseRecto()
    {
        return $this->morphOne(Image::class, 'imageable')
            ->where('images.type', 'license-recto')
            ->orderBy('images.created_at', 'desc');
    }
    
    /**
     * Get the user's license verso.
     */
    public function licenseVerso()
    {
        return $this->morphOne(Image::class, 'imageable')
            ->where('images.type', 'license-verso')
            ->orderBy('images.created_at', 'desc');
    }
    
    /**
     * Get the user's vtc recto.
     */
    public function vtcRecto()
    {
        return $this->morphOne(Image::class, 'imageable')
            ->where('images.type', 'vtc-recto')
            ->orderBy('images.created_at', 'desc');
    }
    
    /**
     * Get the user's vtc verso.
     */
    public function vtcVerso()
    {
        return $this->morphOne(Image::class, 'imageable')
            ->where('images.type', 'vtc-verso')
            ->orderBy('images.created_at', 'desc');
    }
    
    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    
    /**
     * Get the order items for the user.
     */
    public function orderItems()
    {
        return $this->hasManyThrough(
            Item::class, 
            Order::class,
            'user_id', // Foreign key on orders table...
            'order_id', // Foreign key on items table...
            'id', // Local key on users table...
            'id' // Local key on orders table...
        );
    }
    
    /**
     * Get the items order for the user.
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'driver_id');
    }
    
    /**
     * Get the user's note.
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }
    
    /**
     * Get user's parent
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
    
    
    /**
     * Get the payment tokens for the user.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
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
        return $this->hasMany(Point::class, 'user_id');
    }
    
    /**
     * The positions that belong to the user.
     */
    public function positions()
    {
        return $this->belongsToMany(Point::class, 'user_point')->using(UserPoint::class);
    }
    
    /**
     * Get rating count
     */
    public function rating()
    {
        return (float) $this->notes()->whereDate('notes.created_at', date('Y-m-d'))->avg('star');
    }
    
    /**
     * Get reviews count
     */
    public function reviews()
    {
        return (int) $this->notes()->whereDate('notes.created_at', date('Y-m-d'))->count();
    }
    
    /**
     * Get the main role of the user
     */
    public function role()
    {
        if($this->isAdmin())
        {
            return trans('messages.admin');
        }
        if($this->isDriver())
        {
            return trans('messages.driver');
        }
        return trans('messages.customer');
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
     * Get the rides created by the user.
     */
    public function ridesCreated()
    {
        return $this->hasMany(Ride::class);
    }
    
    /**
     * Get the rides drived by the user.
     */
    public function ridesDrived()
    {
        return $this->hasMany(Ride::class, 'driver_id', 'id');
    }
    
    /**
     * Get the ride points by the user.
     */
    public function ridePoints()
    {
        return $this->hasMany(RidePoint::class, 'user_id', 'id');
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
    * Check user can join ride
    *
    * @param int $ride_id
    */
    public function canJoinRide($ride_id)
    {
        return null !== $this->ridesDrived()->where('id', $ride_id)->first();
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

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'App.User.'.$this->id;
    }
}
