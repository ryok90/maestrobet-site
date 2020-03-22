<?php

namespace Usuario\Service\Factory;

use Interop\Container\ContainerInterface;
use Usuario\Service\UsuarioService;
use Zend\ServiceManager\Factory\FactoryInterface;

class UsuarioServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new UsuarioService($entityManager);
    }
}
