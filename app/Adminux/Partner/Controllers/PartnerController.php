<?php

namespace App\Adminux\Partner\Controllers;

use App\Adminux\Partner\Models\Partner;
use App\Adminux\Admin\Controllers\AdminPartnerController;
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
        if(request()->ajax()) return Datatables::of($partner::query())
            ->addColumn('id2', 'adminux.components.datatables.link_show_link')
            ->addColumn('active2', 'adminux.components.datatables.status')
            ->addColumn('actions', 'adminux.components.datatables.link_edit_button')
            ->rawColumns(['id2', 'active2', 'actions'])
            ->toJson();

        return view('adminux.components.datatables.index')->withDatatables([
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Name</th>
                        <th style="min-width:60px">Active</th>
                        <th style="min-width:120px">Created At</th>
                        <th>Action</th>',

            'columns' => "{ data: 'id2', name: 'id', className: 'text-center' },
                          { data: 'name', name: 'name' },
                          { data: 'active2', name: 'active', className: 'text-center' },
                          { data: 'created_at', name: 'created_at', className: 'text-center' },
                          { data: 'actions', name: 'actions', className: 'text-center', orderable: false }"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Partner $partner)
    {
        return view('adminux.components.create')->withModel($partner)->withFields($this->getFields($partner));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Partner $partner)
    {
        $request->validate([
            'name'   => 'required|unique:'.$partner->getTable(),
            'active' => 'in:Y,""',
        ]);

        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $partner = $partner->create($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $partner));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        if(request()->ajax()) return (new AdminPartnerController)->getIndex($partner);

        return view('adminux.components.show')->withModel($partner)->withMany([ (new AdminPartnerController)->getIndex($partner) ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        return view('adminux.components.edit')->withModel($partner)->withFields($this->getFields($partner));
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
            'name'   => 'required|unique:'.$partner->getTable().',name,'.$partner->id,
            'active' => 'in:Y,""',
        ]);

        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $partner->update($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $partner));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();

        return redirect(route(explode('/', request()->path())[1].'.index'));
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Partner $partner)
    {
        $form = new \App\Adminux\Form($partner);
        $form->addFields([
            $form->display([ 'label' => 'ID' ]),
            $form->text([ 'label' => 'Name' ]),
            $form->switch([ 'label' => 'Active' ]),
        ]);

        return $form->getFields();
    }
}
