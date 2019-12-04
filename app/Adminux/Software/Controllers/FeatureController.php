<?php

namespace App\Adminux\Software\Controllers;

use App\Adminux\Software\Models\Feature;
use Illuminate\Http\Request;
use App\Adminux\AdminuxController;
use Yajra\Datatables\Datatables;

class FeatureController extends AdminuxController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Feature $feature)
    {
        if(request()->ajax()) return Datatables::of($feature::query())
            ->addColumn('software', function($row) { return @$row->software->software; })
            ->addColumn('id2', 'adminux.pages.inc.link_show_link')
            ->rawColumns(['id2'])
            ->toJson();

        return view('adminux.pages.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Feature</th>
                        <th style="min-width:120px">Software</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "feature", name: "feature" },
                          { data: "software", name: "software" },
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
        return parent::createView($feature);
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
            'software_id' => 'required',
            'feature' => 'required'
        ]);

        $feature = $feature->create($request->all());

        return parent::saveRedirect($feature);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        return view('adminux.pages.show')->withModel($feature);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature)
    {
        return parent::editView($feature);
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

        return parent::saveRedirect($feature);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        return parent::destroyRedirect($feature);
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Feature $feature)
    {
        $form = new \App\Adminux\Form($feature);
        return [
            $form->display([ 'label' => 'ID' ]),
            $form->select([ 'label' => 'Software', 'editable' => false ]),
            $form->text([ 'label' => 'Feature' ]),
        ];
    }
}
