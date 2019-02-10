<?php

namespace App\Http\Controllers\Adminux;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

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
        if(Auth::guard('adminux')->check()) return redirect('admin');
        return view('adminux.login');
    }

    protected function loggedOut(Request $request)
    {
        return redirect('admin');
    }
}
