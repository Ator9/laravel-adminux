<?php

namespace App\Adminux\Role\Controllers;

use App\Adminux\Role\Models\Role;
use App\Adminux\Admin\Controllers\AdminRoleController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Role $role)
    {
        if(request()->ajax()) return Datatables::of($role::query())
            ->addColumn('id2', 'adminux.components.datatables.link_show_link')
            ->rawColumns(['id2'])
            ->toJson();

        return view('adminux.components.datatables.index')->withDatatables([
            'order' => '[[ 1, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Name</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "name", name: "name" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Role $role)
    {
        return view('adminux.components.create')->withModel($role)->withFields($this->getFields($role));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Role $role)
    {
        $request->validate([
            'name'   => 'required|unique:'.$role->getTable(),
            'active' => 'in:Y,""',
        ]);

        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $role = $role->create($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $role));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        if(request()->ajax()) return (new AdminRoleController)->getIndex($role);

        return view('adminux.components.show')->withModel($role)->withMany([ (new AdminRoleController)->getIndex($role) ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('adminux.components.edit')->withModel($partner)->withFields($this->getFields($partner));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'   => 'required|unique:'.$role->getTable().',name,'.$role->id,
            'active' => 'in:Y,""',
        ]);

        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $role->update($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $role));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect(route(explode('/', request()->path())[1].'.index'));
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Role $role)
    {
        $form = new \App\Adminux\Form($role);
        $form->addFields([
            $form->display([ 'label' => 'ID' ]),
            $form->text([ 'label' => 'Name' ]),
            $form->switch([ 'label' => 'Active' ]),
        ]);

        return $form->getFields();
    }
}
