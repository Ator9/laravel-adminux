<?php

if(file_exists(__DIR__.'/base.php')) return require(__DIR__.'/base.php');

return [

    'admin_name' => 'Adminux',
    'panel_name' => 'Panel',
    'custom_routes' => app_path('Adminux/your_routes_path.php'),
    'custom_routespanel' => app_path('Adminux/your_routespanel_path.php'),
    'admin_favicon' => env('APP_URL').'/vendor/adminux/resources/favicon.ico',
    'panel_favicon' => env('APP_URL').'/vendor/adminux/frontend/favicon.ico',
    'login_redirect' => 'dashboard',
    'panel_redirect' => 'dashboard',
    'menu_software' => [], // list software name == menu name

    // Left menu:
    'menu' => [
        'default' => [
            'Accounts' => [
                'icon' => 'users',
                'items' => [
                    [ 'dir'=> 'accounts', 'name' => 'Accounts', /*'module_config' => [ 'emails' => 'mas emails' ]*/ ],
                    [ 'dir'=> 'accounts_products', 'name' => 'Products' ],
                ]
            ],
            'Billing' => [
                'icon' => 'dollar-sign',
                'items' => [
                    [ 'dir'=> 'billings', 'name' => 'Billing' ],
                    [ 'dir'=> 'billings_accounts-summary', 'name' => 'Accounts' ],
                ]
            ],
            'Services' => [
                'icon' => 'truck',
                'items' => [
                    [ 'dir'=> 'services', 'name' => 'Services' ],
                    [ 'dir'=> 'services_plans', 'name' => 'Plans' ],
                ]
            ],
            'Tickets' => [
                'icon' => 'check-square',
                'items' => [
                    [ 'dir'=> 'tickets', 'name' => 'Tickets' ],
                ]
            ],
        ],

        'superuser' => [ // This checks superuser == 'Y' to show
            'Admins' => [
                'icon' => 'lock',
                'items' => [
                    [ 'dir'=> 'admins', 'name' => 'Admins' ],
                    [ 'dir'=> 'admins_roles', 'name' => 'Roles' ],
                    [ 'dir'=> 'admins_permission', 'name' => 'Permissions' ],
                    [ 'dir'=> 'admins_currencies', 'name' => 'Currencies' ],
                    [ 'dir'=> 'admins_languages', 'name' => 'Languages' ],
                    [ 'dir'=> 'admins_logs', 'name' => 'Logs' ],
                    [ 'dir'=> 'admins_phpinfo', 'name' => 'PHP Info' ],
                    [ 'dir'=> 'admins_webhook', 'name' => 'Webhook' ],
                    [ 'dir'=> 'admins_composer', 'name' => 'Composer / Shell' ],
                ]
            ],
            'Partners' => [
                'icon' => 'share-2',
                'items' => [
                    [ 'dir'=> 'partners', 'name' => 'Partners' ],
                    [ 'dir'=> 'partners_services', 'name' => 'Services' ],
                ]
            ],
            'Software' => [
                'icon' => 'box',
                'items' => [
                    [ 'dir'=> 'software', 'name' => 'Software' ],
                    [ 'dir'=> 'software_features', 'name' => 'Features' ],
                ]
            ],
        ]
    ]
];
