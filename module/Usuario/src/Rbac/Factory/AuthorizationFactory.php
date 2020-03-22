<?php

namespace Usuario\Rbac\Factory;

use Usuario\Rbac\Authorization;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfcRbac\Service\AuthorizationService;
use Interop\Container\ContainerInterface;

class AuthorizationFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        $authorizationService = $services->get(AuthorizationService::class);

        return new Authorization($authorizationService);
    }
}