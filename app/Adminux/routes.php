<?php

Route::namespace('\App\Adminux')->group(function() {
    Route::post('login', 'LoginController@login')->name('login');
    Route::get('login', 'LoginController@showLoginForm')->name('showLoginForm');
    Route::get('logout', 'LoginController@logout')->name('logout');

    Route::middleware('adminux')->group(function() {
        Route::get('', 'Admin\Controllers\AdminController@dashboard')->name('admin.dashboard');
        Route::get('admin_phpinfo', 'Admin\Controllers\AdminController@phpinfo')->name('admin.phpinfo');

        foreach(\File::directories(__DIR__) as $dir) {
            $module = basename($dir);
            Route::resource(strtolower($module), $module.'\Controllers\\' . $module.'Controller');
        }

        // Automated URL based on request (example: admin_partner):
        if(Request::path() != '/') {
            $split = explode('_', basename(Request::path()));
            if(count($split) == 2) {
                $class = ucfirst(end($split));
                if(file_exists(__DIR__.'/'.$class.'/Controllers/'.$class.'Controller.php')) {
                    Route::resource(basename(Request::path()), $class.'\Controllers\\'.$class.'Controller');
                }
            }
        }
    });
});
