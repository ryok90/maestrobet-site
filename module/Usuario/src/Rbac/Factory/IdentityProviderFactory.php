<?php

namespace Usuario\Rbac\Factory;

use Doctrine\ORM\EntityManager;
use Usuario\Rbac\IdentityProvider;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class IdentityProviderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        $authenticationProvider = $services->get('authentication');
        $entityManager = $services->get(EntityManager::class);

        return new IdentityProvider($authenticationProvider, $entityManager);
    }
}