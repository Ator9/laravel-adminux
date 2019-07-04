<?php

namespace App\Adminux\Partner\Controllers;

use App\Adminux\Partner\Models\Partner;
use App\Adminux\Admin\Controllers\AdminPartnerController;
use App\Adminux\Product\Controllers\ProductController;
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
            ->rawColumns(['id2', 'active2'])
            ->toJson();

        return view('adminux.components.datatables.index')->withDatatables([
            'order' => '[[ 1, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Partner</th>
                        <th style="min-width:60px">Active</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "partner", name: "partner" },
                          { data: "active2", name: "active", className: "text-center" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
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
            'partner' => 'required|unique:'.$partner->getTable(),
            'active' => 'in:Y,""',
        ]);

        if($request->filled('config')) $request->merge(['config' => json_encode($request->config) ]);
        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $partner = $partner->create($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $partner));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        if(request()->ajax()) {
            if(request()->table == 'admin_partner') return (new AdminPartnerController)->getIndex($partner);
            // elseif(request()->table == 'products') return (new ProductController)->getIndex($partner);
        }

        return view('adminux.components.show')->withModel($partner)->withMany([
            (new AdminPartnerController)->getIndex($partner),
            // (new ProductController)->getIndex($partner)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'partner' => 'required|unique:'.$partner->getTable().',partner,'.$partner->id,
            'active' => 'in:Y,""',
        ]);

        if($request->filled('config')) $request->merge(['config' => json_encode($request->config) ]);
        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $partner->update($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $partner));
    }

    /**
     * Remove the specified resource from storage.
     *
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
            $form->text([ 'label' => 'Partner' ]),
            $form->moduleConfig([ 'label' => 'Config' ]),
            $form->switch([ 'label' => 'Active' ]),
        ]);

        return $form->getFields();
    }
}
