<?php

namespace Financeiro\Service\Factory;

use Doctrine\ORM\EntityManager;
use Financeiro\Service\LancamentoService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class LancamentoServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get(EntityManager::class);

        return new LancamentoService($entityManager);
    }
}