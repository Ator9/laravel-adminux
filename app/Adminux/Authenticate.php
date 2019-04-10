<?php

namespace App\Adminux;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if(auth('adminux')->check()) return $next($request);
        return redirect('admin/login');
    }
}
