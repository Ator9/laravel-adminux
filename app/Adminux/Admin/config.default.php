<?php
$config = [
    'navigation'  => [
        'enabled' => true,
        'name'    => 'Admins',
        'icon'    => 'lock', // Feather icons
        'submenu' => [ // dir url => name
            'admins_partners' => 'partners',
            'admins_roles' => 'roles',
            'admins_services' => 'services',
            'admins_currencies' => 'currencies',
            'admins_languages' => 'languages',
            'admins_logs' => 'logs',
            'admins_phpinfo' => 'PHP Info',
        ]
    ]
];
