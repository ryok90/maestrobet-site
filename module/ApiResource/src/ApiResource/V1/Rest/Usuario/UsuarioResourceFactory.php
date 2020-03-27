<?php
namespace ApiResource\V1\Rest\Usuario;

use Doctrine\ORM\EntityManager;
use Usuario\Service\UsuarioService;

class UsuarioResourceFactory
{
    public function __invoke($services)
    {
        $service = $services->get(UsuarioService::class);
        $entityManager = $services->get(EntityManager::class);

        return new UsuarioResource($service, $entityManager);
    }
}
