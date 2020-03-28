<?php

namespace Usuario\Service\Factory;

use Interop\Container\ContainerInterface;
use Usuario\Rbac\IdentityProvider;
use Usuario\Service\UsuarioService;
use Zend\ServiceManager\Factory\FactoryInterface;

class UsuarioServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $identityProvider = $container->get(IdentityProvider::class);
        $identity = $identityProvider->getIdentity();

        return new UsuarioService($entityManager, $identity);
    }
}
