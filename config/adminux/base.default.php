<?php

if(file_exists(__DIR__.'/base.php')) return require(__DIR__.'/base.php');

return [

    'project_name' => 'Adminux',

    // Left menu:
    'menu' => [
        'default' => [
            'Accounts' => [
                'icon' => 'users',
                'items' => [
                    [ 'dir'=> 'accounts', 'name' => 'Accounts' ],
                    [ 'dir'=> 'accounts_products', 'name' => 'Products' ],
                ]
            ],
            'Services' => [
                'icon' => 'truck',
                'items' => [
                    [ 'dir'=> 'services', 'name' => 'Services' ],
                    [ 'dir'=> 'services_plans', 'name' => 'Plans' ],
                ]
            ],
        ],

        'superuser' => [ // This checks superuser == 'Y' to show
            'Admins' => [
                'icon' => 'lock',
                'items' => [
                    [ 'dir'=> 'admins', 'name' => 'Admins' ],
                    [ 'dir'=> 'admins_roles', 'name' => 'Roles' ],
                    [ 'dir'=> 'admins_currencies', 'name' => 'Currencies' ],
                    [ 'dir'=> 'admins_languages', 'name' => 'Languages' ],
                    [ 'dir'=> 'admins_logs', 'name' => 'Logs' ],
                    [ 'dir'=> 'admins_phpinfo', 'name' => 'PHP Info' ],
                    [ 'dir'=> 'admins_webhook', 'name' => 'Webhook' ],
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
