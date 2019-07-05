<?php
$config = [
    'navigation'  => [
        'enabled' => true,
        'name'    => 'Admins',
        'icon'    => 'lock', // Feather icons
        'submenu' => [ // dir url => name
            'admin_partner' => 'Partners',
            'admin_role' => 'Roles',
            'admin_service' => 'Services',
            'admin_currency' => 'Currencies',
            'admin_language' => 'Languages',
            'admin_logs' => 'Logs',
            'admin_phpinfo' => 'PHP Info',
        ]
    ]
];
