<?php

namespace App\Adminux\Software\Controllers;

use App\Adminux\Software\Models\Software;
use Illuminate\Http\Request;
use App\Adminux\AdminuxController;
use Yajra\Datatables\Datatables;

class SoftwareController extends AdminuxController
{
    public function __construct()
    {
        $this->middleware('adminux_superuser');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Software $software)
    {
        if(request()->ajax()) return Datatables::of($software::query())
            ->addColumn('id2', 'adminux.backend.pages.inc.link_show_link')
            ->rawColumns(['id2'])
            ->toJson();

        return view('adminux.backend.pages.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Software</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "software", name: "software" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Software $software)
    {
        return parent::createView($software);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Software $software)
    {
        $request->validate([
            'software' => 'required|unique:'.$software->getTable(),
        ]);

        $software = $software->create($request->all());

        return parent::saveRedirect($software);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Software $software)
    {
        if(request()->ajax()) return (new SoftwareFeatureController)->getIndex($software);

        return view('adminux.backend.pages.show')->withModel($software)->withRelations([(new SoftwareFeatureController)->getIndex($software)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Software $software)
    {
        return parent::editView($software);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Software $software)
    {
        $request->validate([
            'software' => 'required|unique:'.$software->getTable().',software,'.$software->id,
        ]);

        $software->update($request->all());

        return parent::saveRedirect($software);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Software $software)
    {
        return parent::destroyRedirect($software);
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Software $software)
    {
        $form = new \App\Adminux\Form($software);
        return [
            $form->display([ 'label' => 'ID' ]),
            $form->text([ 'label' => 'Software' ]),
            $form->text([ 'label' => 'Software Class' ]),
        ];
    }
}
