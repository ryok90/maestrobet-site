<?php

namespace Importacao\V1\Rpc\AgenteBanca;

use Doctrine\ORM\EntityManager;
use Zend\Hydrator\HydratorPluginManager;
use Zend\ServiceManager\ServiceManager;
use Usuario\Service\UsuarioService;

class AgenteBancaControllerFactory
{
    /**
     * @param ServiceManager $serviceManager
     */
    public function __invoke($serviceManager)
    {
        $service = $serviceManager->get(UsuarioService::class);
        $entityManager = $serviceManager->get(EntityManager::class);
        $hydratorManager = $serviceManager->get(HydratorPluginManager::class);

        return new AgenteBancaController($service, $entityManager, $hydratorManager);
    }
}
