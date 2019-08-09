<?php

namespace App\Adminux\Service\Controllers;

use App\Adminux\Service\Models\Service;
use Illuminate\Http\Request;
use App\Adminux\AdminuxController;
use Yajra\Datatables\Datatables;

class ServiceController extends AdminuxController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Service $service)
    {
        if(request()->ajax()) return Datatables::of($service::query())
            ->addColumn('id2', 'adminux.pages.inc.link_show_link')
            ->rawColumns(['id2'])
            ->toJson();

        return view('adminux.pages.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Service</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "service", name: "service" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Service $service)
    {
        return parent::createView($service);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Service $service)
    {
        $request->validate([
            'service' => 'required|unique:'.$service->getTable(),
        ]);

        $service = $service->create($request->all());

        return parent::saveRedirect($service);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        if(request()->ajax()) return (new ServiceFeatureController)->getIndex($service);

        return view('adminux.pages.show')->withModel($service)->withRelations([(new ServiceFeatureController)->getIndex($service)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return parent::editView($service);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'service' => 'required|unique:'.$service->getTable().',service,'.$service->id,
        ]);

        $service->update($request->all());

        return parent::saveRedirect($service);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        return parent::destroyRedirect($service);
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Service $service)
    {
        $form = new \App\Adminux\Form($service);
        return [
            $form->display([ 'label' => 'ID' ]),
            $form->text([ 'label' => 'Service' ]),
            $form->text([ 'label' => 'Service Class' ]),
        ];
    }
}
