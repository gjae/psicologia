<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

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
     * Create a new controller instance.
     *
     * @return array
     */
    
    protected function credentials(Request $request)
    {   
        /*
        It returns an array with both input credentials, in order to compare them with the database credentials in the attemptLogin method.
        */
        return $request->only($this->username(), 'password');
    }


    public function login(Request $request)
    {
        $this->validateLogin($request);
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        session(['lastActivityTime'=>time()]);
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }
        
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard('web')->user())
                ?: redirect()->intended($this->redirectPath());
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors= [];
        $user= User::where($this->username(), $request->input($this->username()))->first();

        //Validates if the input matches one of the database users.
        if(!$user){
            //It assigns error message to form username field
            $errors[$this->username()] = trans('auth.failed');
        }else{
            //It assigns error message to form password field
            $errors['password'] = trans('auth.password');
        }
        throw ValidationException::withMessages($errors);
    }
}
