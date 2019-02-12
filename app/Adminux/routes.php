<?php

// Route::prefix('admin')->group(base_path('app/Adminux/routes.php'));

Route::namespace('\App\Adminux')->group(function() {
    Route::post('login', 'LoginController@login')->name('login');
    Route::get('login', 'LoginController@showLoginForm')->name('showLoginForm');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::get('', 'Admins\Controllers\AdminController@dashboard')->name('admin.dashboard');

    Route::resource('admins', 'Admins\Controllers\AdminController');
    Route::resource('partners', 'Partners\Controllers\PartnerController');

    // foreach(File::directories(__DIR__) as $dir) {
    //     $module = basename($dir);
    //     Route::resource(strtolower($module), $module.'\Controllers\\'.$module.'Controller');
    // }
});

if(file_exists(__DIR__.'/routescustom.php')) include __DIR__.'/routescustom.php';
