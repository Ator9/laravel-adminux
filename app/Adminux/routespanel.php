<?php

use Illuminate\Support\Str;

Route::namespace('\App\Adminux\Panel')->group(function() {
    Route::post('login', 'LoginController@login')->name('panel.login');
    Route::get('login', 'LoginController@showLoginForm')->name('panel.showLoginForm');
    Route::get('logout', 'LoginController@logout')->name('panel.logout');

    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('panel.password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('panel.password.email');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('panel.password.update');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('panel.password.reset');

    Route::middleware(App\Adminux\Panel\Authenticate::class)->group(function() {
        Route::get('', function() { return redirect()->route('panel.login'); });
        Route::get('dashboard', 'Controllers\PanelController@dashboard');

        // Your custom routes. You can override "\App\Adminux" like "\App\Xxx\Yyy\Controller@method":
        if(file_exists(config('adminux.base.default.custom_routespanel'))) require(config('adminux.base.default.custom_routespanel'));
    });
});
