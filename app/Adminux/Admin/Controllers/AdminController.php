<?php

namespace App\Adminux\Admin\Controllers;

use App\Adminux\Admin\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Admin $admin)
    {
        if(request()->ajax()) return Datatables::of($admin::query())
            ->addColumn('id2', 'adminux.components.datatables.link_show_link')
            ->addColumn('active2', 'adminux.components.datatables.status')
            ->rawColumns(['id2', 'active2'])
            ->toJson();

        return view('adminux.components.datatables.index')->withDatatables([
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-25">E-mail</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th style="min-width:60px">Active</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => "{ data: 'id2', name: 'id', className: 'text-center' },
                          { data: 'email', name: 'email' },
                          { data: 'firstname', name: 'firstname' },
                          { data: 'lastname', name: 'lastname' },
                          { data: 'active2', name: 'active', className: 'text-center' },
                          { data: 'created_at', name: 'created_at', className: 'text-center' }"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Admin $admin)
    {
        return view('adminux.components.create')->withModel($admin)->withFields($this->getFields($admin));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Admin $admin)
    {
        $request->validate([
            'email'    => 'required|email|unique:'.$admin->getTable(),
            'password' => 'required',
            'active'   => 'in:Y,""',
        ]);

        $request->merge(['password' => Hash::make($request->password)]);
        if(!$request->filled('firstname')) $request->merge(['firstname' => '']);
        if(!$request->filled('lastname')) $request->merge(['lastname' => '']);
        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $admin = $admin->create($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $admin));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        if(request()->ajax()) return (new AdminPartnerController)->getIndex($admin);

        return view('adminux.components.show')->withModel($admin)->withMany([ (new AdminPartnerController)->getIndex($admin) ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        return view('adminux.components.edit')->withModel($admin)->withFields($this->getFields($admin));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'email'    => 'required|email|unique:'.$admin->getTable().',email,'.$admin->id,
            'active'   => 'in:Y,""',
        ]);

        if($request->filled('password') && !Hash::check($request->password, $admin->password)) {
            $request->merge(['password' => Hash::make($request->password)]);
        } else $request->request->remove('password');

        if(!$request->filled('firstname')) $request->merge(['firstname' => '']);
        if(!$request->filled('lastname')) $request->merge(['lastname' => '']);
        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $admin->update($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $admin));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect(route(explode('/', request()->path())[1].'.index'));
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Admin $admin)
    {
        $form = new \App\Adminux\Form($admin);
        $form->addFields([
            $form->display([ 'label' => 'ID' ]),
            $form->email([ 'label' => 'E-mail' ]),
            $form->text([ 'label' => 'First Name' ]),
            $form->text([ 'label' => 'Last Name' ]),
            $form->password([ 'label' => 'Password' ]),
            $form->switch([ 'label' => 'Active' ]),
        ]);

        return $form->getFields();
    }

    /**
     * Display admin dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('adminux.dashboard');
    }

    /**
     * Display admin logs
     *
     * @return \Illuminate\Http\Response
     */
    public function logs()
    {
        return view('adminux.components.card', [
            'header' => 'Logs',
            'body'   => nl2br(\File::get(storage_path().'/logs/laravel-'.date('Y-m-d').'.log'))
        ]);
    }

    /**
     * Display admin phpinfo
     *
     * @return \Illuminate\Http\Response
     */
    public function phpinfo()
    {
        if(isset($_GET['raw'])) {
            phpinfo();
            return;
        }

        return view('adminux.components.blank')
        ->withBody('<iframe src="admin_phpinfo?raw=1" style="height:calc(100vh - 64px);width:100%;border:none"></iframe>');
    }
}
