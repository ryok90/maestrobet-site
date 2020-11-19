<?php
namespace Usuario\Rbac;

class RoleProvider
{
    // Roles
    const ROLE_ADMIN = 'admin';
    const ROLE_AGENTE = 'agente';
    const ROLE_BANCA = 'banca';
    const ROLE_CLIENTE = 'cliente';
    const ROLE_GUEST = 'guest';
    const ROLE_REPASSE = 'repasse';
    const ROLE_USUARIO = 'usuario';

    // Admin permissions
    const ADMIN_FETCH = 'admin-fetch';
    const ADMIN_CREATE = 'admin-create';
    const ADMIN_UPDATE = 'admin-update';
    const ADMIN_DELETE = 'admin-delete';
    const ADMIN_PATCH = 'admin-patch';

    // Cliente permissions
    const CLIENTE_FETCH = 'cliente-fetch';
    const CLIENTE_CREATE = 'cliente-create';
    const CLIENTE_UPDATE = 'cliente-update';
    const CLIENTE_DELETE = 'cliente-delete';
    const CLIENTE_PATCH = 'cliente-patch';
    const CLIENTE_FETCH_SELF = 'cliente-fetch-self';
    const CLIENTE_UPDATE_SELF = 'cliente-update-self';
    const CLIENTE_PATCH_SELF = 'cliente-patch-self';

    // Usuario permissions
    const USUARIO_FETCH = 'usuario-fetch';
    const USUARIO_CREATE = 'usuario-create';
    const USUARIO_UPDATE = 'usuario-update';
    const USUARIO_DELETE = 'usuario-delete';
    const USUARIO_PATCH = 'usuario-patch';
    const USUARIO_FETCH_SELF = 'usuario-fetch-self';
    const USUARIO_UPDATE_SELF = 'usuario-update-self';
    const USUARIO_PATCH_SELF = 'usuario-patch-self';

    public static function getFullRoles()
    {
        return [
            self::ROLE_ADMIN => [
                'children' => [
                    self::ROLE_CLIENTE,
                ],
                'permissions' => [
                    self::ADMIN_FETCH,
                    self::ADMIN_CREATE,
                    self::ADMIN_UPDATE,
                    self::ADMIN_DELETE,
                    self::ADMIN_PATCH,
                ]
            ],
            self::ROLE_CLIENTE => [
                'children' => [self::ROLE_USUARIO],
                'permissions' => [
                    self::CLIENTE_FETCH_SELF,
                    self::CLIENTE_UPDATE_SELF,
                    self::CLIENTE_PATCH_SELF,
                ]
            ],
            self::ROLE_USUARIO => [
                'children' => [self::ROLE_GUEST],
                'permissions' => [
                    self::USUARIO_FETCH_SELF,
                    self::USUARIO_UPDATE_SELF,
                    self::USUARIO_PATCH_SELF,
                ]
            ],
            self::ROLE_GUEST => [],
        ];
    }

    public static function getRolesNames()
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_AGENTE,
            self::ROLE_BANCA,
            self::ROLE_CLIENTE,
            self::ROLE_GUEST,
            self::ROLE_REPASSE,
            self::ROLE_USUARIO,
        ];
    }

    public static function getAssertionFactories()
    {
        return [];
    }

    public static function getAssertionMap()
    {
        return [];
    }
}
