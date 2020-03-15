<?php

namespace Usuario\Service;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use User\Authentication\iAuthAwareInterface;
use Usuario\Entity\Usuario;

class UsuarioService implements iAuthAwareInterface
{
    protected $entityManager;

    protected $authenticatedIdentity;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setAuthenticatedIdentity(Usuario $usuario)
    {
        $this->authenticatedIdentity = $usuario;
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthenticatedIdentity()
    {
        return $this->authenticatedIdentity;
    }

    public function insertUsuario(Usuario $usuario)
    {
        if ($usuario->getId()) {
            throw new RuntimeException();
        }
        $usuario->setDataCriacao(new DateTime());

        $this->entityManager->persist($usuario);
        $this->entityManager->flush($usuario);

        return $usuario;
    }
}
