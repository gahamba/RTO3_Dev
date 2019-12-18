<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Verified
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
            if(Auth::user()->email_verified != 0){
                return redirect('/unverified');
            }
        }


        return $next($request);
    }
}
