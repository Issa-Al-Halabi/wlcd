<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Socialite;
use App\User;
use Illuminate\Support\MessageBag;
use Spatie\Activitylog\Contracts\Activity;
use App\Setting;


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
    public function authenticated()
    {

        
        $gsetting = Setting::first();

        if( Auth::User()->role == "instructor" || Auth::User()->role == "user")
        {

            if(isset($gsetting->activity_enable))
            {
                if($gsetting->activity_enable == '1')
                {
                    $project = new User();

                    activity()
                       ->useLog('Login')
                       ->performedOn($project)
                       ->causedBy(auth()->user())
                       ->withProperties(['customProperty' => 'Login'])
                       ->log('Logged In')
                       ->subject('Login');

                }
            }

        }

        

        if (Auth::User()->status == 1)
        {
           
            if( Auth::User()->role == "admin") 
            {
                
                return redirect()->route('admin.index');
                
            }
            elseif( Auth::User()->role == "instructor")
            {

                return redirect()->route('instructor.index');

            }
            elseif( auth()->user()->getRoleNames()[0] != 'user' )
            {
                return redirect()->route('admin.index');

            }
            else
            {
                return redirect('/home');
      
            }
        }
        else{
            
            Auth::logout();
            return redirect()->route('login')->with('delete','You are deactivated !'); 
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function handleProviderCallback($social)
    {
        $userSocial = Socialite::driver($social)->user();
        $user = User::where(['email' => $userSocial->getEmail()])->first();

        // set the remember me cookie if the user check the box
        $remember = $request->has('remember') ? true : false;

        // attempt to do the login
       
        if(Auth::attempt(['email' => $request->get('email') , 'password' => $request->get('password') ,
        'status' => 1], $remember)){
        
                return redirect()->intended('/home');
        }
        else
        {
            $errors = new MessageBag(['email' => ['Email or password is invalid.']]);
            return Redirect::back()->withErrors($errors)->withInput($request->except('password'));
        }



        if ($user) {
            Auth::login($user);
            return redirect()-> action('HomeController@index');
        }
        else {
            return view('auth.register', ['name'=> $userSocial->getName(), 
                                            'email' => $userSocial->getEmail()]);
        }
    }

    
}
