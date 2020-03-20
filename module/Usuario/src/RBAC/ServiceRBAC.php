<?php

namespace Usuario\RBAC;

use Zend\Permissions\Rbac\Rbac;

class ServiceRBAC
{

    const ROLE_USUARIO = 'usuario';

    const ROLE_ADMIN = 'admin';

    protected $rbac;

    public function __construct()
    {
        $this->rbac = new Rbac;
        $this->addRoles();
    }

    public function addRoles()
    {
        $this->rbac->addRole(self::ROLE_ADMIN);
        $this->rbac->addRole(self::ROLE_USUARIO, [self::ROLE_ADMIN]);
    }

    /**
     * @return Rbac
     */
    public function getRBAC()
    {
        return $this->rbac;
    }
}