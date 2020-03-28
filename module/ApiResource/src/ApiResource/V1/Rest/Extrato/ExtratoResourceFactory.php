<?php

namespace ApiResource\V1\Rest\Extrato;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Usuario\Rbac\IdentityProvider;

class ExtratoResourceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $entityManager = $container->get(EntityManager::class);
        $identity = $container->get(IdentityProvider::class)->getIdentity();

        return new ExtratoResource(null, $entityManager, $identity);
    }
}
