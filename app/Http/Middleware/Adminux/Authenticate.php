<?php

namespace App\Http\Middleware\Adminux;

use Closure;
use Auth;

class Authenticate
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

        $user = Auth::user();
        dd($user);exit;
        // return $next($request);
        // dd(auth()::hasUser());exit;
        // dd(auth());exit;

        if(auth()->user()->id) return $next($request);
        return redirect('login');
    }
}
