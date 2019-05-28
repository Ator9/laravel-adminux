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
        return \Auth::guard('adminux');
    }

    public function showLoginForm()
    {
        if($this->guard()->check()) return redirect($this->redirectTo().'/dashboard');
        return view('adminux.login');
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
