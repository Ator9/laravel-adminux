<?php

namespace App\Http\Middleware\Adminux;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        // Auth::guard('admin')->check();exit;

        if (! $request->expectsJson()) {
            return route('adminux/login');
        }
    }
}
