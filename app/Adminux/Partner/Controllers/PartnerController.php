<?php

namespace App\Adminux\Partner\Controllers;

use App\Adminux\Partner\Models\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class PartnerController extends Controller
{
    // Admin Configuration:
    public $adminConfig = [
        'name' => 'Partners',
        'icon' => 'layers', // Feather icons
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Partner $partner)
    {
        if(isset($_GET['datatables'])) return Datatables::of($partner::query())->make(true);

        return view('adminux.components.datatables')->withDatatables([
            'thead' => '<th>#</th>
                        <th class="w-75">Name</th>
                        <th>Active</th>
                        <th>Created At</th>',

            'config' => "{ data: 'id', name: 'id' },
                         { data: 'name', name: 'name' },
                         { data: 'active', name: 'active' },
                         { data: 'created_at', name: 'created_at' }"
        ]);
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
     * @param  \App\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        //
    }
}
