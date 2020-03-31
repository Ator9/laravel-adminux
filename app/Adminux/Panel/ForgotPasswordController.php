<?php

namespace App\Adminux\Panel;

use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends \App\Adminux\ForgotPasswordController
{
    public function broker()
    {
        return Password::broker('adminuxpanel');
    }

    public function showLinkRequestForm()
    {
        return view('adminux.password-email')->withTitle(config('adminux.base.default.panel_name', 'Panel'));
    }
}
