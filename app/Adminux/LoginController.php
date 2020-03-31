<?php

namespace App\Adminux;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    protected function guard()
    {
        return auth('adminux');
    }

    public function showLoginForm()
    {
        if($this->guard()->check()) return redirect($this->redirectTo().'/'.config('adminux.base.default.login_redirect', 'dashboard'));
        return view('adminux.login')->withTitle(config('adminux.base.default.project_name', 'Admin'));
    }

    protected function loggedOut(Request $request)
    {
        return redirect($this->redirectTo());
    }

    function authenticated(Request $request, $user)
    {
        $user->last_login_ip = $request->getClientIp();
        $user->last_login_at = \Carbon\Carbon::now();
        $user->save();
    }

    // Check if active admin:
    protected function credentials(Request $request)
    {
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'active' => 'Y'];
    }

    protected function redirectTo()
    {
        return request()->route()->getPrefix();
    }
}
