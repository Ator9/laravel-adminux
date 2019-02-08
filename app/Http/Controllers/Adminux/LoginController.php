<?php

namespace App\Http\Controllers\Adminux;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function guard()
    {
        return Auth::guard('adminux');
    }

    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
        return view('adminux/login');
    }

    // protected function guard()
    // {
    //     return Auth::guard('adminux');
    // }
    //
    // public function login()
    // {
    //     return view('adminux/login');
    // }
}
