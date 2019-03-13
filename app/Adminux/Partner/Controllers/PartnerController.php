<?php

namespace App\Adminux\Partner\Controllers;

use App\Adminux\Partner\Models\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Partner $partner)
    {
        if(isset($_GET['datatables'])) {
            return Datatables::of($partner::query())
            ->addColumn('id', 'adminux.components.datatables.link_show_link')
            ->addColumn('active', 'adminux.components.datatables.status')
            ->addColumn('actions', 'adminux.components.datatables.link_edit_button')
            ->rawColumns(['id', 'active', 'actions'])
            ->toJson();
        }

        return view('adminux.components.datatables.index')->withDatatables([
            'disableClickableRow' => true,
            'thead' => '<th class="text-center">ID</th>
                        <th class="w-75">Name</th>
                        <th>Active</th>
                        <th class="text-center">Created At</th>
                        <th>Action</th>',

            'columns' => "{ data: 'id', name: 'id', className: 'text-center' },
                          { data: 'name', name: 'name' },
                          { data: 'active', name: 'active', className: 'text-center' },
                          { data: 'created_at', name: 'created_at', className: 'text-center' },
                          { data: 'actions', name: 'actions', className: 'text-center' }"
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
        return view('adminux.components.show')->withModel($partner);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        $form = new \App\Adminux\Form($partner);

        $fields = [
            $form->display([ 'label' => 'ID', 'name' => 'id' ]),
            $form->email([ 'label' => 'Name', 'name' => 'name' ]),
            $form->boolean([ 'label' => 'Active', 'name' => 'active' ]),
            $form->textarea(),
        ];

        return view('adminux.components.edit')->withModel($partner)->withFields($fields);
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
        $request->validate([
            'name' => 'required'
        ]);

        $partner->update($request->all());

        return redirect(route('partner.show', $partner));
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
