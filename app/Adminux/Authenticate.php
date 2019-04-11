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
        if(auth('adminux')->check()) {

            // Live check if active admin:
            if(auth('adminux')->user()->active == 'Y') return $next($request);
            else auth('adminux')->logout();
        }

        return redirect('admin/login');
    }
}
