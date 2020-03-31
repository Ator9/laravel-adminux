<?php

namespace App\Adminux\Panel\Controllers;

use App\Http\Controllers\Controller;
use App\Adminux\Account\Models\Account;
use App\Adminux\Helper;

class PanelController extends Controller
{
    public function dashboard()
    {
        return view('adminux.frontend.dashboard');
    }
}
