<?php

namespace Usuario\Rbac;

use Doctrine\ORM\EntityManager;
use Usuario\Entity\Usuario;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;
use ZF\MvcAuth\MvcAuthEvent;

class AuthenticationListener
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        $identity = $mvcAuthEvent->getIdentity();

        if ($identity instanceof AuthenticatedIdentity) {
            $idUsuario = $identity->getRoleId();
            $usuario = $this->entityManager->find(Usuario::class, $idUsuario);

            $identity->setName($usuario->getRoles());

        }
        return $identity;
    }
}