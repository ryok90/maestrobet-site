<?php

namespace Usuario\Assertion;

use Usuario\Entity\Usuario;
use ZfcRbac\Assertion\AssertionInterface as AssertionAssertionInterface;
use ZfcRbac\Service\AuthorizationService;

class UserMatchAssertion implements AssertionAssertionInterface
{
    /**
     * @var int
     */
    protected $idFromRoute;

    public function __construct($idFromRoute)
    {
        $this->idFromRoute = $idFromRoute;
    }

    /**
     * @param AuthorizationService $rbac
     * @return boolean
     */
    public function assert(AuthorizationService $authService)
    {
        $authenticatedIdentity = $authService->getIdentity();

        if ($authenticatedIdentity instanceof Usuario) {
            
            return $authenticatedIdentity->getId() == $this->idFromRoute;
        }

        return false;
    }
}
