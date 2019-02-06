<?php

namespace App\Http\Controllers\Adminux;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminuxController extends Controller
{
    public function index()
    {
        return view('adminux/index');
    }
}
