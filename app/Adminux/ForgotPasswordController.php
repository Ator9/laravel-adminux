<?php

namespace App\Adminux;

use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function broker()
    {
        return Password::broker('adminux');
    }

    public function showLinkRequestForm()
    {
        return view('adminux.password-email');
    }
}
