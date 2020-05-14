<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'phone';
    }

    /*
    * Facebook Login
    */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            if(isset($user->user['id'])){
                $result = User::where(['email' => $user->user['email'], 'facebook_id' => $user->user['id']  ])->first();
                if(is_null($result)){
                    $u = new User([
                        'name' => $user->user['name'],
                        'email' => $user->user['email'],
                        'facebook_id' => $user->user['id'],
                        'password' => Hash::make(uniqid()),
                    ]);
                    return $u->save() ? redirect()->route('register.success') : redirect()->route('register.error') ;
                }

                return redirect('/login'); 
            }
            
        } catch (Exception $e) {
            return redirect('/login');
        }

    }

}
