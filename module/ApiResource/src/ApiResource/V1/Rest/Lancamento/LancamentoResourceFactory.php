<?php

namespace ApiResource\V1\Rest\Lancamento;

use Doctrine\ORM\EntityManager;
use Financeiro\Service\LancamentoService;
use Interop\Container\ContainerInterface;
use Usuario\Rbac\IdentityProvider;
use Zend\Hydrator\HydratorPluginManager;

class LancamentoResourceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $entityManager = $container->get(EntityManager::class);
        $service = $container->get(LancamentoService::class);
        $hydratorManager = $container->get(HydratorPluginManager::class);
        $identity = $container->get(IdentityProvider::class)->getIdentity();

        return new LancamentoResource($service, $entityManager, $identity, $hydratorManager);
    }
}
