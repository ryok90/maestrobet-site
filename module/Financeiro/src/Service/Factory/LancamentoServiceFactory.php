<?php

namespace Financeiro\Service\Factory;

use Doctrine\ORM\EntityManager;
use Financeiro\Service\LancamentoService;
use Interop\Container\ContainerInterface;
use Usuario\Rbac\IdentityProvider;
use Zend\ServiceManager\Factory\FactoryInterface;

class LancamentoServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get(EntityManager::class);
        $identityProvider = $container->get(IdentityProvider::class);
        $identity = $identityProvider->getIdentity();

        return new LancamentoService($entityManager, $identity);
    }
}