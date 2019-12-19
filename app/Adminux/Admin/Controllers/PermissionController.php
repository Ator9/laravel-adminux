<?php

namespace App\Adminux\Admin\Controllers;

use Spatie\Permission\Models\Permission;
// use App\Adminux\Admin\Controllers\AdminRoleController;
use Illuminate\Http\Request;
use App\Adminux\AdminuxController;
use Yajra\Datatables\Datatables;

class PermissionController extends AdminuxController
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
    public function index(Permission $permission)
    {
        if(request()->ajax()) return Datatables::of($permission::query())
            ->addColumn('id2', 'adminux.pages.inc.link_show_link')
            ->rawColumns(['id2'])
            ->toJson();

        return view('adminux.pages.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Name</th>
                        <th class="w-75">Guard Name</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "name", name: "name" },
                          { data: "guard_name", name: "guard_name" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Permission $permission)
    {
        return parent::createView($permission);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Permission $permission)
    {
        $request->validate([
            'name'   => 'required|unique:'.$permission->getTable(),
        ]);

        if(!$request->filled('guard_name')) $request->merge(['guard_name' => '']);

        $permission = $permission->create($request->all());

        return parent::saveRedirect($permission);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        // if(request()->ajax()) return (new AdminRoleController)->getIndex($permission);

        return view('adminux.pages.show')->withModel($permission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return parent::editView($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name'   => 'required|unique:'.$permission->getTable().',name,'.$permission->id,
        ]);

        if(!$request->filled('guard_name')) $request->merge(['guard_name' => '']);

        $permission->update($request->all());

        return parent::saveRedirect($permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return parent::destroyRedirect();
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Permission $permission)
    {
        $form = new \App\Adminux\Form($permission);
        return [
            $form->display([ 'label' => 'ID' ]),
            $form->text([ 'label' => 'Name' ]),
            $form->text([ 'label' => 'Guard Name', 'value' => 'adminux' ]), // TODO default value on insert
        ];
    }
}
