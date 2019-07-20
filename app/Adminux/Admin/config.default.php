<?php
$config = [
    'navigation'  => [
        'enabled' => true,
        'name'    => 'Admins',
        'icon'    => 'lock', // Feather icons
        'submenu' => [ // dir url => name
            'admins_roles' => 'Roles',
            'admins_currencies' => 'Currencies',
            'admins_languages' => 'Languages',
            'admins_logs' => 'Logs',
            'admins_phpinfo' => 'PHP Info',
        ]
    ]
];
