<?php

namespace App\Adminux\Config\Controllers;

use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('adminux.components.card')->withHeader('Config')->withBody('');
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
     * Display admin logs
     *
     * @return \Illuminate\Http\Response
     */
    public function logs()
    {
        return view('adminux.components.card', [
            'header' => 'Logs',
            'body'   => nl2br(\File::get(storage_path().'/logs/laravel-'.date('Y-m-d').'.log'))
        ]);
    }

    /**
     * Display admin phpinfo
     *
     * @return \Illuminate\Http\Response
     */
    public function phpinfo()
    {
        if(isset($_GET['raw'])) {
            phpinfo();
            return;
        }

        return view('adminux.components.blank')
        ->withBody('<iframe src="admins_phpinfo?raw=1" style="height:calc(100vh - 64px);width:100%;border:none"></iframe>');
    }
}
