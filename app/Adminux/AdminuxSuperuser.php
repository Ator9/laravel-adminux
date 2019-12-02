<?php

namespace App\Adminux;

class AdminuxSuperuser
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
        abort_if(auth('adminux')->user()->superuser != 'Y', 403);

        return $next($request);
    }
}
