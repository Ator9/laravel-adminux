<?php

namespace App\Adminux;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use DB;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'admin';

    protected function guard()
    {
        return Auth::guard('adminux');
    }

    public function showLoginForm()
    {
        if($this->guard()->check()) return redirect($this->redirectTo);
        return view('adminux.login');
    }

    protected function loggedOut(Request $request)
    {
        return redirect($this->redirectTo);
    }

    function authenticated(Request $request, $user)
    {
        $user->last_login_ip = $request->getClientIp();
        $user->last_login_at = DB::raw('now()');
        $user->save();
    }
}
