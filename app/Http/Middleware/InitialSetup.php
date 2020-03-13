<?php

namespace App\Http\Middleware;

use App\Device;
use Auth;
use Closure;

class InitialSetup
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
        $devices = Device::where('company_id', '=', Auth::user()->company_id)->get();
        if(count($devices) < 1 && Auth::user()->user_type == 0){
            return redirect('/initial_setup');
        }
        return $next($request);
    }
}
