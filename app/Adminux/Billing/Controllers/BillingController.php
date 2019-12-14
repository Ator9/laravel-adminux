<?php

namespace App\Adminux\Billing\Controllers;

use App\Http\Controllers\Controller;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('adminux.pages.billing');
    }
}
