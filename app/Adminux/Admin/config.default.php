<?php
$config = [
    'navigation'  => [
        'enabled' => true,
        'name'    => 'Admins',
        'icon'    => 'lock', // Feather icons
        'submenu' => [ // dir url => name
            'role'    => 'Roles',
            'partner' => 'Partners',
            'logs'    => 'Logs',
            'phpinfo' => 'PHP Info',
        ]
    ]
];
