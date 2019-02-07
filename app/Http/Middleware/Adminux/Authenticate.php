<?php

namespace App\Http\Middleware\Adminux;

use Closure;

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
        return $next($request);

        if(auth()->user()->isAdmin == 1) {
            return $next($request);
        }
        return redirect('home')->with('error', 'You have not admin access');
    }
}
