<?php

namespace App\Adminux\Panel;

class LoginController extends \App\Adminux\LoginController
{
    protected function guard()
    {
        return auth('adminuxpanel');
    }

    public function showLoginForm()
    {
        if($this->guard()->check()) return redirect($this->redirectTo().'/dashboard');
        return view('adminux.login');
    }
}
