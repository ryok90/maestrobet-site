<?php
namespace ApiResource\V1\Rest\Usuario;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Usuario\Rbac\IdentityProvider;
use Usuario\Service\UsuarioService;
use Zend\Hydrator\HydratorPluginManager;

class UsuarioResourceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $service = $container->get(UsuarioService::class);
        $entityManager = $container->get(EntityManager::class);
        $hydratorManager = $container->get(HydratorPluginManager::class);
        $identity = $container->get(IdentityProvider::class);

        return new UsuarioResource($service, $entityManager, $identity, $hydratorManager);
    }
}
