<?php

Route::namespace('\App\Adminux')->group(function() {
    Route::post('login', 'LoginController@login')->name('login');
    Route::get('login', 'LoginController@showLoginForm')->name('showLoginForm');
    Route::get('logout', 'LoginController@logout')->name('logout');

    Route::middleware('adminux')->group(function() {
        Route::get('', 'Admin\Controllers\AdminController@dashboard')->name('admin.dashboard');

        $split = explode('_' , basename(Request::path()));
        if(count($split) == 2) {
            Route::resource(basename(Request::path()), ucfirst($split[1]).'\Controllers\\'.ucfirst($split[1]).'Controller');
        } else {
            Route::resource('admin', 'Admin\Controllers\AdminController');
            Route::resource('partner', 'Partner\Controllers\PartnerController');
        }
    });
});
