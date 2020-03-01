<?php

namespace Usuario\Service;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Usuario\Entity\Usuario;

class UsuarioService
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
