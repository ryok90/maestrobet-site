<?php

namespace Usuario\Service;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Usuario\Authentication\iAuthAwareInterface;
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

    public function getUsuario($id)
    {
        $usuarioRepo = $this->entityManager->getRepository(Usuario::class);
        $usuario = $usuarioRepo->findOneBy(['id' => $id]);

        return $usuario;
        
    }

    public function getUsuarios()
    {
        $usuarioRepo = $this->entityManager->getRepository(Usuario::class);
        $usuarios = $usuarioRepo->findAll();

        return $usuarios;
    }
}
