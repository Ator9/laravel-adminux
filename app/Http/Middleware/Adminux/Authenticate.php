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
        if(Auth::guard('adminux')->check())
        {
            dd($request);
            return view('admin/index');
        }
        return redirect('admin/login');
    }
}
