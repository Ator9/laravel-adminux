<?php

Route::namespace('\App\Adminux')->group(function() {
    Route::post('login', 'LoginController@login')->name('login');
    Route::get('login', 'LoginController@showLoginForm')->name('showLoginForm');
    Route::get('logout', 'LoginController@logout')->name('logout');

    Route::middleware('adminux')->group(function() {
        Route::get('', 'Admin\Controllers\AdminController@dashboard')->name('admin.dashboard');
        Route::get('admin_composer', 'Admin\Controllers\AdminController@composer');
        Route::get('admin_phpinfo', 'Admin\Controllers\AdminController@phpinfo');

        foreach(\File::directories(__DIR__) as $dir) {
            $module = basename($dir);
            Route::resource(strtolower($module), $module.'\Controllers\\' . $module.'Controller');
        }

        // Automated URL based on request (example: admin_partner):
        if(strpos(Request::path(), '_') !== false) {
            $split = explode('/', Request::path());
            $uri   = next($split);

            $split2 = explode('_', $uri);
            if(count($split2) == 2) {
                $class = ucfirst(end($split2));
                if(file_exists(__DIR__.'/'.$class.'/Controllers/'.$class.'Controller.php')) {
                    Route::resource($uri, $class.'\Controllers\\'.$class.'Controller');
                }
            }
        }
    });
});
