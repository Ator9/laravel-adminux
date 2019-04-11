<?php
$config = [
    'navigation'  => [
        'enabled' => true,
        'name'    => 'Admins',
        'icon'    => 'settings', // Feather icons
        'submenu' => [ // dir url => name
            'role'    => 'Roles',
            'partner' => 'Partners',
            'logs'    => 'Logs',
            'phpinfo' => 'PHP Info',
        ]
    ]
];
