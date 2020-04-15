<?php

namespace App\Adminux\Admin\Controllers;

use App\Adminux\Admin\Models\Admin;
use Illuminate\Http\Request;
use App\Adminux\AdminuxController;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;

class AdminController extends AdminuxController
{
    public function __construct()
    {
        $this->middleware('adminux_superuser', ['except' => ['webhook']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Admin $admin)
    {
        if(request()->ajax()) return Datatables::of($admin::query())
            ->addColumn('id2', 'adminux.backend.pages.inc.link_show_link')
            ->addColumn('active2', 'adminux.backend.pages.inc.status')
            ->rawColumns(['id2', 'active2'])
            ->toJson();

        return view('adminux.backend.pages.index')->withDatatables([
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-25">E-mail</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th style="min-width:60px">Active</th>
                        <th style="min-width:120px">Last Login</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "email", name: "email" },
                          { data: "firstname", name: "firstname" },
                          { data: "lastname", name: "lastname" },
                          { data: "active2", name: "active", className: "text-center" },
                          { data: "last_login_at", name: "last_login_at", className: "text-center" },
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
        if(request()->ajax()) {
            if(request()->table == 'admin_partner') return (new AdminPartnerController)->getIndex($admin);
            else return (new AdminRoleController)->getIndex($admin);
        }

        return view('adminux.backend.pages.show')->withModel($admin)->withRelations([
            (new AdminPartnerController)->getIndex($admin),
            (new AdminRoleController)->getIndex($admin),
        ]);
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
            $form->email([ 'label' => 'E-mail' ]),
            $form->password([ 'label' => 'Password' ]),
            $form->text([ 'label' => 'First Name' ]),
            $form->text([ 'label' => 'Last Name' ]),
            $form->select([ 'label' => 'Language' ]),
            $form->switch([ 'label' => 'Active' ]),
        ];
    }

    /**
     * Display admin logs
     *
     * @return \Illuminate\Http\Response
     */
    public function logs()
    {
        // config/logging.php: 'channels' => ['daily']
        $file = storage_path().'/logs/laravel-'.date('Y-m-d').'.log';

        if(isset($_GET['delete'])) {
            \File::delete($file);
            return back();
        }

        return view('adminux.backend.pages.card', [
            'header' => 'Logs',
            'header_buttons' => '<a href="?delete" class="btn btn-danger btn-sm my-n1"><span class="feather-adminux" data-feather="trash-2"></span> '.__('adminux.delete').'</a>',
            'body'   => \File::exists($file) ? nl2br(\File::get($file)) : 'No errors today :)'
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

        return view('adminux.backend.pages.blank')->withBody('<iframe src="?raw=1" style="height:calc(100vh - 64px);width:100%;border:none"></iframe>');
    }

    public function composer()
    {
        if(isset($_GET['command'])) {

            echo date('Y-m-d H:i:s').'<br><br>';
            echo 'Current User: '.exec('whoami').'<br>';
            echo 'Current Path: '.exec('pwd').'<br><br>';

            switch($_GET['command']) {
                case 'composer_install':
                    echo $command = 'cd /var/www/'.$_SERVER['HTTP_HOST'].'/private && composer install';
                    exec($command." 2>&1", $output);
                    break;

                case 'config_clear':
                    $output = \Artisan::call('config:clear');
                    break;

                case 'config_cache':
                    $output = \Artisan::call('config:cache');
                    break;
            }

            dd($output);
            return;
        }

        $body = '<div class="container-fluid">
                    <div class="card mt-3">
                        <div class="card-header">Information</div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Env: '.env('APP_ENV').'</li>
                                <li class="list-group-item">Cache: '.env('CACHE_DRIVER').'</li>
                            </ul>

                            <button class="m-3 btn btn-warning" onclick="$(\'#run\').attr(\'src\',\'?command=config_clear\')">
                                php artisan config:clear
                            </button>
                            <button class="m-3 btn btn-warning" onclick="$(\'#run\').attr(\'src\',\'?command=config_cache\')">
                                php artisan config:cache
                            </button>
                            <button class="m-3 btn btn-danger" onclick="$(\'#run\').attr(\'src\',\'?command=composer_install\')">
                                composer install
                            </button>
                        </div>
                    </div>
                    <iframe id="run" style="height:calc(100vh - 64px);width:100%;border:none"></iframe>
                </div>';

        return view('adminux.backend.pages.blank')->withBody($body);
    }

    /**
     * Display Webhook Sync
     *
     * sudo -u user ssh-keygen
     * sudo -u user git clone git@bitbucket.org:xxx/yyy.git .
     * sudo chmod -R 777 storage
     *
     * sudo -u user ln -s /var/www/site.com/private/public/ /var/www/site.com/web/
     * sudo -u user git pull
     *
     * sudo -u user cp .env.example .env
     * APP_ENV=production
     * APP_DEBUG=false
     *
     * sudo -u user composer install
     * php artisan key:generate
     * php artisan migrate
     * sudo -u user php artisan storage:link
     * sudo chown -R user:group .
     *
     * ispconfig > Apache Directives: DocumentRoot "{DOCROOT_CLIENT}/public"
     *
     * Example Public Route for Bitbucket (add @ App\Http\Middleware\VerifyCsrfToken $except = ['webhook_ispconfig']):
     * Route::post('/webhook_ispconfig', '\App\Adminux\Admin\Controllers\AdminController@webhook');
     *
     * @return \Illuminate\Http\Response
     */
    public function webhook()
    {
        if(isset($_GET['sync'])) {

            if(auth('adminux')->check()) {
                echo date('Y-m-d H:i:s').'<br>';
                echo 'Starting Git Sync...<br><br>';
                echo 'Current User: '.exec('whoami').'<br>';
                echo 'Current Path: '.exec('pwd').'<br><br>';
            }

            echo $command = 'cd /var/www/'.$_SERVER['HTTP_HOST'].'/private && git pull';
            exec($command." 2>&1", $output);
            dd($output);

            return;
        }

        return view('adminux.backend.pages.blank')->withBody('<iframe src="?sync" style="height:calc(100vh - 64px);width:100%;border:none"></iframe>');
    }
}
