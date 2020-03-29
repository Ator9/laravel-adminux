<?php

namespace App\Adminux\Panel;

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
        if(auth('adminuxpanel')->check()) {

            \App::setLocale(auth('adminuxpanel')->user()->language->language);

            // Live check if active admin:
            if(auth('adminuxpanel')->user()->active == 'Y') return $next($request);
            else auth('adminuxpanel')->logout();
        }

        return redirect(request()->route()->getPrefix().'/login');
    }
}
