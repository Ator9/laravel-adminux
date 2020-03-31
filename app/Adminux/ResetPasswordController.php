<?php

namespace App\Adminux;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/';

    public function broker()
    {
        return Password::broker('adminux');
    }

    protected function redirectTo()
    {
        return request()->route()->getPrefix();
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('adminux.password-reset')->with([
            'token' => $token,
            'email' => $request->email,
            'title' => config('adminux.base.default.project_name', 'Admin'),
        ]);
    }
}
