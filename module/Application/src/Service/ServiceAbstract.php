<?php

namespace Application\Service;

use Usuario\Entity\Usuario;
use Application\Repository\RepositoryAbstract;
use Doctrine\ORM\EntityManager;

class ServiceAbstract
{
    const USER_ALREADY_REGISTERED_MESSAGE = 'Este usuário já está registrado.';
    const USER_ALREADY_REGISTERED_CODE = 2;
    const USER_NOT_FOUND_MESSAGE = 'Usuário não encontrado.';
    const USER_NOT_FOUND_CODE = 3;
    const MUST_BE_LOGGED_IN_MESSAGE = 'Você precisa estar autenticado para executar esta ação.';
    const MUST_BE_LOGGED_IN_CODE = 4;
    const PERMISSION_DENIED_MESSAGE = 'Você não possui permissões para executar esta ação.';
    const PERMISSION_DENIED_CODE = 5;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var Usuario
     */
    protected $identity;

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param \Usuario\Entity\Usuario $identity
     */
    public function __construct(EntityManager $entityManager, Usuario $identity)
    {
        $this->entityManager = $entityManager;
        $this->identity = $identity;
    }

    /**
     * @return Usuario
     */
    public function getUsuarioAutenticado()
    {
        return $this->identity;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param string $class
     * @return RepositoryAbstract
     */
    public function getRepository($class)
    {
        return $this->entityManager->getRepository($class);
    }
}
