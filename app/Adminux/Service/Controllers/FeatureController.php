<?php

namespace App\Adminux\Service\Controllers;

use App\Adminux\Service\Models\Feature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Feature $feature)
    {
        if(request()->ajax()) return Datatables::of($feature::query())
            ->addColumn('service', function($row) { return @$row->service->service; })
            ->addColumn('id2', 'adminux.components.datatables.link_show_link')
            ->rawColumns(['id2'])
            ->toJson();

        return view('adminux.components.datatables.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Feature</th>
                        <th style="min-width:120px">Service</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "feature", name: "feature" },
                          { data: "service", name: "service" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Feature $feature)
    {
        return view('adminux.components.create')->withModel($feature)->withFields($this->getFields($feature));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Feature $feature)
    {
        $request->validate([
            'service_id' => 'required',
            'feature' => 'required'
        ]);

        $feature = $feature->create($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $feature));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        return view('adminux.components.show')->withModel($feature);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature)
    {
        return view('adminux.components.edit')->withModel($feature)->withFields($this->getFields($feature));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feature $feature)
    {
        $feature->update($request->only(['feature'])); // no extra validation required with this field

        return redirect(route(explode('/', $request->path())[1].'.show', $feature));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        $feature->delete();

        return redirect(route(explode('/', request()->path())[1].'.index'));
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Feature $feature)
    {
        $form = new \App\Adminux\Form($feature);
        $form->addFields([
            $form->display([ 'label' => 'ID' ]),
            $form->select([ 'label' => 'Service', 'editable' => false ]),
            $form->text([ 'label' => 'Feature' ]),
        ]);

        return $form->getFields();
    }
}
