<?php

namespace ApiResource\V1\Rpc\ImportacaoUsuario;

use Doctrine\ORM\EntityManager;
use Zend\Hydrator\HydratorPluginManager;
use Zend\ServiceManager\ServiceManager;
use Usuario\Service\UsuarioService;

class ImportacaoUsuarioControllerFactory
{
    /**
     * @param ServiceManager $serviceManager
     */
    public function __invoke($serviceManager)
    {
        $service = $serviceManager->get(UsuarioService::class);
        $entityManager = $serviceManager->get(EntityManager::class);
        $hydratorManager = $serviceManager->get(HydratorPluginManager::class);


        return new ImportacaoUsuarioController($service, $entityManager, $hydratorManager);
    }
}
