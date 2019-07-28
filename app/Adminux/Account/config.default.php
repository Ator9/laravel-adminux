<?php
$config = [
    'navigation'  => [
        'enabled' => true,
        'name'    => 'Accounts',
        'icon'    => 'users', // Feather icons
        'submenu' => [ // dir url => name
            'accounts_plans' => 'Plans'
        ]
    ],
    'Account' => [
        'default_config' => [
            // 'lang' => 'Language code (en, es).',
        ]
    ],
    'AccountPlan' => [
        'default_config' => [
            // 'lang' => 'Language code (en, es).',
        ]
    ]
];
