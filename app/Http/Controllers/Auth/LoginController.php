<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;



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
    protected $redirectTo = '/home';
    public $flag='0'; 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        //    'g-recaptcha-response' => 'required|recaptcha',
        ]);
    }

    protected function credentials(Request $request)
    {
        if(is_numeric($request->get('email'))){
            return ['phone'=>$request->get('email'),'password'=>$request->get('password')];
        }
        return $request->only($this->username(), 'password');
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
      }


      public function login(Request $request)
      {
         
          $this->validateLogin($request);

          if (method_exists($this, 'hasTooManyLoginAttempts') &&
              $this->hasTooManyLoginAttempts($request)) {
              $this->fireLockoutEvent($request);
  
           return $this->sendLockoutResponse($request);

          }
  
          if ($this->attemptLogin($request)) {
              return $this->sendLoginResponse($request);
          }
  

          $this->incrementLoginAttempts($request);
  
          return $this->sendFailedLoginResponse($request);
      }
  

      

}
