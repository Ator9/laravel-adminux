<?php

namespace App\Adminux\Admin\Controllers;

use App\Adminux\Admin\Models\Admin;
use Illuminate\Http\Request;
use App\Adminux\AdminuxController;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;

class AdminController extends AdminuxController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Admin $admin)
    {
        if(request()->ajax()) return Datatables::of($admin::query())
            ->addColumn('id2', 'adminux.pages.inc.link_show_link')
            ->addColumn('active2', 'adminux.pages.inc.status')
            ->addColumn('role', function($row) { return @$row->role->role; })
            ->rawColumns(['id2', 'active2'])
            ->toJson();

        return view('adminux.pages.index')->withDatatables([
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-25">E-mail</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Role</th>
                        <th style="min-width:60px">Active</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "email", name: "email" },
                          { data: "firstname", name: "firstname" },
                          { data: "lastname", name: "lastname" },
                          { data: "role", name: "role_id" },
                          { data: "active2", name: "active", className: "text-center" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Admin $admin)
    {
        return parent::createView($admin);
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
            'language_id' => 'required',
            'active'   => 'in:Y,""',
        ]);

        $request->merge(['password' => Hash::make($request->password)]);
        if(!$request->filled('firstname')) $request->merge(['firstname' => '']);
        if(!$request->filled('lastname')) $request->merge(['lastname' => '']);
        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $admin = $admin->create($request->all());

        return parent::saveRedirect($admin);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        if(request()->ajax()) return (new AdminPartnerController)->getIndex($admin);

        return view('adminux.pages.show')->withModel($admin)->withRelations([ (new AdminPartnerController)->getIndex($admin) ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        return parent::editView($admin);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'email'    => 'required|email|unique:'.$admin->getTable().',email,'.$admin->id,
            'language_id' => 'required',
            'active'   => 'in:Y,""',
        ]);

        if($request->filled('password') && !Hash::check($request->password, $admin->password)) {
            $request->merge(['password' => Hash::make($request->password)]);
        } else $request->request->remove('password');

        if(!$request->filled('firstname')) $request->merge(['firstname' => '']);
        if(!$request->filled('lastname')) $request->merge(['lastname' => '']);
        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $admin->update($request->all());

        return parent::saveRedirect($admin);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        return parent::destroyRedirect($admin);
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Admin $admin)
    {
        $form = new \App\Adminux\Form($admin);
        return [
            $form->display([ 'label' => 'ID' ]),
            $form->select([ 'label' => 'Role' ]),
            $form->email([ 'label' => 'E-mail' ]),
            $form->password([ 'label' => 'Password' ]),
            $form->text([ 'label' => 'First Name' ]),
            $form->text([ 'label' => 'Last Name' ]),
            $form->select([ 'label' => 'Language' ]),
            $form->switch([ 'label' => 'Active' ]),
        ];
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
        return view('adminux.pages.card', [
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

        return view('adminux.pages.blank')
        ->withBody('<iframe src="admins_phpinfo?raw=1" style="height:calc(100vh - 64px);width:100%;border:none"></iframe>');
    }

    /**
     * Display Webhook Sync
     *
     * sudo -u user ssh-keygen
     * sudo -u user git clone git@bitbucket.org:xxx/yyy.git .
     * sudo chown -R user:group .
     * sudo chmod -R 777 storage
     *
     * sudo -u user ln -s /var/www/site.com/private/public/ web/
     * sudo -u user git pull
     *
     * sudo -u user cp .env.example .env
     * sudo -u user composer install
     * php artisan key:generate
     *
     * ispconfig > Apache Directives: DocumentRoot "{DOCROOT_CLIENT}/public"
     *
     * @return \Illuminate\Http\Response
     */
    public function webhook()
    {
        if(isset($_GET['sync'])) {
            echo date('Y-m-d H:i');
            return;
        }

        return view('adminux.pages.blank')
        ->withBody('<iframe src="'.url(substr(request()->route()->getPrefix(), 1)).'/webhook?sync" style="height:calc(100vh - 64px);width:100%;border:none"></iframe>');
    }
}
