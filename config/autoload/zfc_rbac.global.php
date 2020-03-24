<?php

use ApiResource\V1\Rest\Usuario\UsuarioResource;
use Usuario\Rbac\IdentityProvider;
use Usuario\Rbac\RoleProvider;
use ZfcRbac\Role\InMemoryRoleProvider;

return [
    'zfc_rbac' => [
        'identity_provider' => IdentityProvider::class,
        'guest_role' => RoleProvider::ROLE_GUEST,
        'role_provider' => [
            InMemoryRoleProvider::class => RoleProvider::getFullRoles()
        ],
        'assertion_manager' => [
            'factories' => RoleProvider::getAssertionFactories()
        ],
        'assertion_map' => RoleProvider::getAssertionMap(),
    ]
];
