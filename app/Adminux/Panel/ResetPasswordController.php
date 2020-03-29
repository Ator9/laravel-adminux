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
}
