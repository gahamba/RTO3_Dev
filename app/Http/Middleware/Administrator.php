<?php

namespace App\Http\Middleware;

use App\Device;
use Auth;
use Closure;

class Administrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::check()) {
            if(Auth::user()->user_type != 0 && Auth::user()->user_type != -1){
                return redirect('/noaccess');
            }
        }


        return $next($request);
    }
}
