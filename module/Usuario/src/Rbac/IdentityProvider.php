<?php

namespace Usuario\Rbac;

use Zend\Authentication\AuthenticationService;
use ZfcRbac\Identity\IdentityProviderInterface;

class IdentityProvider implements IdentityProviderInterface
{
    private $rbacIdentity = null;

    private $authenticationProvider;

    public function __construct(AuthenticationService $authenticationProvider)
    {
        $this->authenticationProvider = $authenticationProvider;
    }

    public function getIdentity()
    {
        if ($this->rbacIdentity === null) {

            $this->rbacIdentity = $this->authenticationProvider->getIdentity();
            return $this->rbacIdentity;
        }

    }
}