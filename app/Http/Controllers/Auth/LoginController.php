<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
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
	 * Check user's role and redirect user based on their role
	 * @return 
	 */
	public function authenticated()
	{
		if(auth()->user()->isAdmin())
		{
			return redirect()->route('admin.dashboard');
		}
		
		return redirect()->route('customer.dashboard');
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
                
                $u = User::where('facebook_id', $user->user['id'])->first();
                if(!$u){
                    $u = User::where('email', $user->user['email'])->first();
                    if(!$u){
                        $u = User::create([
                            'name' => $user->user['name'],
                            'email' => $user->user['email'],
                            'facebook_id' => $user->user['id'],
                            'password' => Hash::make(uniqid()),
                        ]);
                        $u->save();
                        $role = Role::where('name', Role::CUSTOMER)->first();
                        if($role){
                            $u->roles()->save($role);
                        }    
                    }
                }

                auth()->login($u);
				
                return redirect('/');
    
            }
        } catch (Exception $e) {
            return redirect('/login');
        }
    }

}
