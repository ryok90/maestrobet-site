<?php

namespace Usuario\Rbac\Factory;

use Interop\Container\ContainerInterface;
use Usuario\Rbac\AuthenticationListener;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthenticationListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        $entityManager = $services->get('doctrine.entitymanager.orm_default');
        
        return new AuthenticationListener($entityManager);
    }
}
