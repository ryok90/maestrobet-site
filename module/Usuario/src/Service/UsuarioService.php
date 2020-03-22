<?php

namespace Usuario\Service;

use Application\Service\ServiceAbstract;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use RuntimeException;
use Usuario\Entity\Usuario;
use ZF\ApiProblem\ApiProblem;

class UsuarioService extends ServiceAbstract
{
    /**
     * @var EntityManagerInterface
     */
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
