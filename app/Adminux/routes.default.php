<?php

use Illuminate\Support\Str;

Route::namespace('\App\Adminux')->group(function() {
    Route::post('login', 'LoginController@login')->name('login');
    Route::get('login', 'LoginController@showLoginForm');
    Route::get('logout', 'LoginController@logout');

    Route::middleware(App\Adminux\Authenticate::class)->group(function() {
        Route::get('', function() { return redirect()->route('login'); });
        Route::get('dashboard', 'Admin\Controllers\AdminDashboardController@dashboard');

        foreach(['logs', 'phpinfo', 'webhook', 'composer'] as $method) {
            Route::get('admins_'.$method, 'Admin\Controllers\AdminController@'.$method);
        }

        Route::get('adminpartner', 'Admin\Controllers\AdminPartnerController@setPartner');
        Route::post('adminpartner', 'Admin\Controllers\AdminPartnerController@store');
        Route::delete('adminpartner/{id}', 'Admin\Controllers\AdminPartnerController@destroy');

        Route::get('accounts_products/{product}/edit-software', 'Account\Controllers\AccountProductController@editSoftware');
        Route::post('accounts_products/{product}/file-upload', 'Account\Controllers\AccountProductController@fileUpload');
        Route::delete('accounts_products/{product}/file-delete', 'Account\Controllers\AccountProductController@fileDelete');

        foreach(\File::directories(__DIR__) as $dir) {
            App\Adminux\Helper::buildRouteResource(basename($dir));
        }

        // Automated URL based on request (example: admins_partners):
        if(strpos(Request::path(), '_') !== false) {
            $split = explode('/', Request::path());
            $uri   = next($split);

            $uri_singular = App\Adminux\Helper::getUriSingular($uri);
            if(count($uri_singular) == 2) {
                $class = ucfirst(end($uri_singular));
                if(file_exists(__DIR__.'/'.ucfirst($uri_singular[0]).'/Controllers/'.$class.'Controller.php')) {
                    Route::resource($uri, ucfirst($uri_singular[0]).'\Controllers\\'.$class.'Controller')->parameters([$uri => strtolower($class)]);
                } elseif(file_exists(__DIR__.'/'.$class.'/Controllers/'.$class.'Controller.php')) {
                    Route::resource($uri, $class.'\Controllers\\'.$class.'Controller')->parameters([$uri => strtolower($class)]);
                } elseif(file_exists(__DIR__.'/'.ucfirst($uri_singular[0]).'/Controllers/'.Str::studly(implode('_', $uri_singular)).'Controller.php')) {
                    Route::resource($uri, ucfirst($uri_singular[0]).'\Controllers\\'.Str::studly(implode('_', $uri_singular)).'Controller')->parameters([$uri => strtolower($class)]);
                }
            }
        }

        // Your custom routes (you can override "\App\Adminux" like "\App\Xxx\Yyy\Controller@method"):
        if(file_exists(__DIR__.'/routes.php')) require __DIR__.'/routes.php';
    });
});
