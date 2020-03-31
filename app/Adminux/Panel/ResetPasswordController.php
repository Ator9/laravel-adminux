<?php

namespace App\Adminux\Panel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends \App\Adminux\ResetPasswordController
{
    public function broker()
    {
        return Password::broker('adminuxpanel');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('adminux.password-reset')->with([
            'token' => $token,
            'email' => $request->email,
            'title' => config('adminux.base.default.panel_name', 'Panel'),
        ]);
    }
}
