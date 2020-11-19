<?php

namespace Importacao\V1\Rpc\Banca;

use Doctrine\ORM\EntityManager;
use Zend\Hydrator\HydratorPluginManager;
use Zend\ServiceManager\ServiceManager;
use Usuario\Service\UsuarioService;

class BancaControllerFactory
{
    /**
     * @param ServiceManager $serviceManager
     */
    public function __invoke($serviceManager)
    {
        $service = $serviceManager->get(UsuarioService::class);
        $entityManager = $serviceManager->get(EntityManager::class);
        $hydratorManager = $serviceManager->get(HydratorPluginManager::class);

        return new BancaController($service, $entityManager, $hydratorManager);
    }
}
