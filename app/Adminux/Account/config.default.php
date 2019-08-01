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
        'module_config' => [
            // 'lang' => 'Language code (en, es).',
        ]
    ],
    'AccountPlan' => [
        'module_config' => [
            // 'lang' => 'Language code (en, es).',
        ]
    ]
];
