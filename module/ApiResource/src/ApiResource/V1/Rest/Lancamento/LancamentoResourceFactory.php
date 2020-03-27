<?php
namespace ApiResource\V1\Rest\Lancamento;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Financeiro\Service\LancamentoService;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\HydratorPluginManager;

class LancamentoResourceFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get(EntityManager::class);
        $service = $container->get(LancamentoService::class);
        $hydratorManager = $container->get(HydratorPluginManager::class);

        return new LancamentoResource($service, $entityManager, $hydratorManager);
    }
}
