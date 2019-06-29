<?php
$config = [
    'navigation'  => [
        'enabled' => true,
        'name'    => 'Admins',
        'icon'    => 'lock', // Feather icons
        'submenu' => [ // dir url => name
            'admin_role'    => 'Roles',
            'admin_partner' => 'Partners',
            'admin_service' => 'Services',
            'admin_currency' => 'Currencies',
            'admin_logs'    => 'Logs',
            'admin_phpinfo' => 'PHP Info',
        ]
    ]
];
