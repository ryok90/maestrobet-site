<?php

use Identity\V1\Rest\Usuario\UsuarioResource;
use Usuario\Assertion\Factory\UserMatchAssertionFactory;
use Usuario\Assertion\UserMatchAssertion;
use Usuario\Entity\Usuario;
use Usuario\Rbac\IdentityProvider;
use ZfcRbac\Role\InMemoryRoleProvider;

return [
    'zfc_rbac' => [
        'identity_provider' => IdentityProvider::class,
        'guest_role' => Usuario::ROLE_GUEST,
        'role_provider' => [
            InMemoryRoleProvider::class => Usuario::ROLES
        ],
        'rest_guard' => [
            'ZF\OAuth2\Controller\Auth' => [
                'token' => [
                    'POST' => true,
                ]
            ],
            'Identity\V1\Rest\Usuario\Controller' => [
                'collection' => [
                    'GET' => [Usuario::ADMIN_FETCH]
                ],
                'entity' => [
                    'GET' => [Usuario::ADMIN_FETCH],
                    'POST' => [Usuario::ADMIN_CREATE],
                    'PUT' => [Usuario::ADMIN_UPDATE],
                    'PATCH' => [Usuario::USUARIO_PATCH],
                    'DELETE' => [Usuario::ADMIN_UPDATE]
                ]
            ]
        ],
        // 'assertion_manager' => [
        //     'factories' => [
        //         UserMatchAssertion::class => UserMatchAssertionFactory::class
        //     ]
        // ],
        // 'assertion_map' => [
        //     Usuario::ADMIN_FETCH => UserMatchAssertion::class
        // ],
    ]
];
