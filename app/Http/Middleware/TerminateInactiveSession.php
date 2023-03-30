<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class TerminateInactiveSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

     /**
      * @var Guard
      */
    protected $auth;

    /**
     * 
     * Create a new middleware instance
     * @param Guard $auth
     * @return void
     */
    public function __construct(Guard $auth){
        $this->auth= $auth;
    }

    /**
     * 
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {
        //get the last activity time from the session
            $lastActivityTime= session('lastActivityTime');

            if($lastActivityTime && (time() - $lastActivityTime> 300)){
                Auth::guard("web")->logout();
                session()->forget('lastActivityTime');
                return redirect('/')->with('session_expired','Tu sesion ha expirado debido a 5 minutos de inactividad');

            }
        return $next($request);
    }
}
