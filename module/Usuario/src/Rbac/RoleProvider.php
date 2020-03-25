<?php

namespace Usuario\Rbac;

class RoleProvider
{
    const ROLE_GUEST = 'guest';
    const ROLE_ADMIN = 'admin';
    const ROLE_USUARIO = 'usuario';

    const ADMIN_FETCH = 'admin-fetch';
    const ADMIN_CREATE = 'admin-create';
    const ADMIN_UPDATE = 'admin-update';
    const ADMIN_DELETE = 'admin-delete';
    const ADMIN_PATCH = 'admin-patch';
    
    const USUARIO_FETCH = 'usuario-fetch';
    const USUARIO_CREATE = 'usuario-create';
    const USUARIO_UPDATE = 'usuario-update';
    const USUARIO_DELETE = 'usuario-delete';
    const USUARIO_PATCH = 'usuario-patch';
    const USUARIO_FETCH_SELF = 'usuario-fetch-self';
    const USUARIO_CREATE_SELF = 'usuario-create-self';
    const USUARIO_UPDATE_SELF = 'usuario-update-self';
    const USUARIO_DELETE_SELF = 'usuario-delete-self';
    const USUARIO_PATCH_SELF = 'usuario-patch-self';

    public static function getFullRoles()
    {
        return [
            self::ROLE_ADMIN => [
                'children' => [self::ROLE_USUARIO],
                'permissions' => [
                    self::ADMIN_FETCH,
                    self::ADMIN_CREATE,
                    self::ADMIN_UPDATE,
                    self::ADMIN_DELETE,
                    self::ADMIN_PATCH,
                ]
            ],
            self::ROLE_USUARIO => [
                'children' => [self::ROLE_GUEST],
                'permissions' => [
                    self::USUARIO_FETCH,
                    self::USUARIO_CREATE,
                    self::USUARIO_UPDATE,
                    self::USUARIO_DELETE,
                    self::USUARIO_PATCH,
                    self::USUARIO_FETCH_SELF,
                    self::USUARIO_CREATE_SELF,
                    self::USUARIO_UPDATE_SELF,
                    self::USUARIO_DELETE_SELF,
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
            self::ROLE_USUARIO,
            self::ROLE_GUEST,
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
