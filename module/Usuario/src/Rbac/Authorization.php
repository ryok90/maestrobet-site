<?php

namespace Usuario\Rbac;

use ZF\MvcAuth\Authorization\AuthorizationInterface;
use ZfcRbac\Service\AuthorizationService;
use ZF\MvcAuth\Identity\IdentityInterface;

class Authorization implements AuthorizationInterface
{
    private $authorizationService;

    private $config;

    public function __construct(AuthorizationService $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }

    public function isAuthorized(IdentityInterface $identity, $resource, $privilege)
    {
        return true;
    }
}
