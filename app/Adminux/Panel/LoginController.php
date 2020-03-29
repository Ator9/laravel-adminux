<?php

namespace App\Adminux\Panel;

use App\Adminux\Helper;

class LoginController extends \App\Adminux\LoginController
{
    protected function guard()
    {
        return auth('adminuxpanel');
    }
}
