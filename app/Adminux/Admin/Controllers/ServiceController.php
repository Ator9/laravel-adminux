<?php

namespace App\Adminux\Admin\Controllers;

use App\Adminux\Admin\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Service $service)
    {
        if(request()->ajax()) return Datatables::of($service::query())
            ->addColumn('id2', 'adminux.components.datatables.link_show_link')
            ->addColumn('currency', function($row) { return @$row->currency->currency; })
            ->rawColumns(['id2'])
            ->toJson();

        return view('adminux.components.datatables.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Service</th>
                        <th class="w-30">Currency</th>
                        <th>Price</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "service", name: "service" },
                          { data: "currency", name: "currency", className: "text-center" },
                          { data: "price", name: "price" },
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
        return view('adminux.components.create')->withModel($service)->withFields($this->getFields($service));
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
            'currency_id' => 'required',
            'price' => 'numeric|between:0,9999999.99',
        ]);

        $service = $service->create($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $service));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('adminux.components.show')->withModel($service);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('adminux.components.edit')->withModel($service)->withFields($this->getFields($service));
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
            'currency_id' => 'required',
            'price' => 'numeric|between:0,9999999.99',
        ]);

        $service->update($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $service));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect(route(explode('/', request()->path())[1].'.index'));
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Service $service)
    {
        $form = new \App\Adminux\Form($service);
        $form->addFields([
            $form->display([ 'label' => 'ID' ]),
            $form->text([ 'label' => 'Service' ]),
            $form->select([ 'label' => 'Currency' ]),
            $form->text([ 'label' => 'Price' ]),
        ]);

        return $form->getFields();
    }
}
