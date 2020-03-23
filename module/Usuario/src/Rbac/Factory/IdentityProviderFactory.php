<?php

namespace Usuario\Rbac\Factory;

use Usuario\Rbac\IdentityProvider;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class IdentityProviderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        $authenticationProvider = $services->get('authentication');
        $entityManager = $services->get('doctrine.entitymanager.orm_default');

        return new IdentityProvider($authenticationProvider, $entityManager);
    }
}