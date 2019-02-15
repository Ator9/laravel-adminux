<?php

Route::namespace('\App\Adminux')->group(function() {
    Route::post('login', 'LoginController@login')->name('login');
    Route::get('login', 'LoginController@showLoginForm')->name('showLoginForm');
    Route::get('logout', 'LoginController@logout')->name('logout');

    Route::middleware('adminux')->group(function() {
        Route::get('', 'Admin\Controllers\AdminController@dashboard')->name('admin.dashboard');

        $split = explode('_', basename(Request::path()));
        $class = ucfirst(end($split));

        Route::resource(basename(Request::path()), $class.'\Controllers\\'.$class.'Controller');
    });
});
