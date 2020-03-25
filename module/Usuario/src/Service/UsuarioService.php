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
            throw new RuntimeException('Usuário já registrado.');
        }

        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        return $usuario;
    }

    public function updateUsuario(Usuario $usuario)
    {
        if (!$usuario->getId()) {
            throw new RuntimeException('Usuário ainda não registrado');
        }
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
