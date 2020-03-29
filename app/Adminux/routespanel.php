<?php

use Illuminate\Support\Str;

Route::namespace('\App\Adminux')->group(function() {
    Route::post('login', 'LoginController@login')->name('login');
    Route::get('login', 'LoginController@showLoginForm');
    Route::get('logout', 'LoginController@logout');

    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');

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

        Route::get('billings_accounts-summary', 'Billing\Controllers\BillingController@accountsSummary');

        Route::get('profile', 'Admin\Controllers\AdminProfileController@show')->name('profile.show');
        Route::get('profile/edit', 'Admin\Controllers\AdminProfileController@edit');
        Route::put('profile', 'Admin\Controllers\AdminProfileController@update');

        // Your custom routes. You can override "\App\Adminux" like "\App\Xxx\Yyy\Controller@method":
        if(file_exists(config('adminux.base.default.custom_routespanel'))) require(config('adminux.base.default.custom_routespanel'));
    });
});
