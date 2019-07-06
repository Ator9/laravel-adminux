<?php

use Illuminate\Support\Str;

Route::namespace('\App\Adminux')->group(function() {
    Route::post('login', 'LoginController@login')->name('login');
    Route::get('login',  'LoginController@showLoginForm');
    Route::get('logout', 'LoginController@logout');

    Route::middleware(App\Adminux\Authenticate::class)->group(function() {
        Route::get('',              function() { return redirect()->route('login'); });
        Route::get('dashboard',     'Admin\Controllers\AdminController@dashboard');
        Route::get('admins_logs',    'Admin\Controllers\AdminController@logs');
        Route::get('admins_phpinfo', 'Admin\Controllers\AdminController@phpinfo');

        foreach(\File::directories(__DIR__) as $dir) {
            App\Adminux\Helper::buildRouteResource(basename($dir));
        }

        Route::get('adminpartner', 'Admin\Controllers\AdminPartnerController@setPartner');
        Route::post('adminpartner', 'Admin\Controllers\AdminPartnerController@store');
        Route::delete('adminpartner/{id}', 'Admin\Controllers\AdminPartnerController@destroy');

        // Automated URL based on request (example: admin_partner):
        if(strpos(Request::path(), '_') !== false) {
            $split = explode('/', Request::path());
            $uri   = next($split);

            $split2 = explode('_', $uri);
            if(count($split2) == 2) {
                $class = Str::singular(ucfirst(end($split2)));
                if(file_exists(__DIR__.'/'.$class.'/Controllers/'.$class.'Controller.php')) {
                    Route::resource($uri, $class.'\Controllers\\'.$class.'Controller')->parameters([$uri => strtolower($class)]);
                } elseif(file_exists(__DIR__.'/'.ucfirst(Str::singular($split2[0])).'/Controllers/'.$class.'Controller.php')) {
                    Route::resource($uri, Str::singular(ucfirst($split2[0])).'\Controllers\\'.$class.'Controller')->parameters([$uri => strtolower($class)]);
                }
            }
        }

        // Your custom routes:
        if(file_exists(__DIR__.'/routes.php')) require __DIR__.'/routes.php';
    });
});
