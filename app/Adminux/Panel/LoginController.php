<?php

namespace App\Adminux\Panel;

class LoginController extends \App\Adminux\LoginController
{
    protected function guard()
    {
        return auth('adminuxpanel');
    }
}
