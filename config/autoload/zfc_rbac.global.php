<?php

// use Usuario\Rbac\IdentityProvider;
// use ZfcRbac\Guard\GuardInterface;

// return [
//     'zfc_rbac' => [
//         'guest_role' => 'guest',
//         'guards' => [],
//         'protection_policy' => GuardInterface::POLICY_ALLOW,
//         'role_provider' => [
//             'ZfcRbac\Role\InMemoryRoleProvider' =>  [
//                 'admin' =>  [
//                     'children'  =>  ['user'],
//                     'permissions'   =>  [
//                         'canDoBaz',
//                     ],
//                 ],
//                 'user' =>  [
//                     'children'  =>  ['guest'],
//                     'permissions'   =>  [
//                         'canDoFoo',
//                         'canDoBar',
//                     ],
//                 ],
//                 'guest' =>  [],
//             ],
//         ],
//     ]
// ];

use Usuario\Entity\Usuario;
use ZfcRbac\Role\InMemoryRoleProvider;

return [
    'zfc_rbac' => [
        'guest_role' => Usuario::ROLE_GUEST,
        'role_provider' => [
            InMemoryRoleProvider::class => Usuario::ROLES
        ]
    ]
];
