<?php

namespace App\Adminux\Admin\Controllers;

use App\Adminux\Admin\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    // Admin Configuration:
    public $adminConfig = [
        'name' => 'Admins',
        'icon' => 'settings', // Feather icons
        'submenu' => [ // dir url => name
            'partner' => 'Partners',
            'logs'    => 'Logs',
            'phpinfo' => 'phpinfo',
        ],
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Admin $admin)
    {
        // $admins = Admin::all();
        // dd($admin::all());
        return view('adminux.admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }

    /**
     * Display admin dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('adminux.dashboard');
    }

    /**
     * Display admin phpinfo
     *
     * @return \Illuminate\Http\Response
     */
    public function phpinfo()
    {
        if(isset($_GET['iframe'])) {
            phpinfo();
            return;
        }

        return view('adminux.components.blank')->withBody('<iframe src="admin_phpinfo?iframe=1" style="height:calc(100vh - 70px);width:100%;border:none"></iframe>');
    }
}
