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
                    [ 'dir'=> 'accounts_plans', 'name' => 'Plans' ],
                ]
            ],
            'Products' => [
                'icon' => 'box',
                'items' => [
                    [ 'dir'=> 'products', 'name' => 'Products' ],
                    [ 'dir'=> 'products_plans', 'name' => 'Plans' ],
                ]
            ],
        ],

        'configuration' => [
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
                    [ 'dir'=> 'partners_products', 'name' => 'Products' ],
                ]
            ],
            'Services' => [
                'icon' => 'truck',
                'items' => [
                    [ 'dir'=> 'services', 'name' => 'Services' ],
                    [ 'dir'=> 'services_features', 'name' => 'Features' ],
                ]
            ],
        ]
    ]
];
