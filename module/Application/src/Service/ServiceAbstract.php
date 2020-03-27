<?php

namespace Application\Service;

use Exception;
use RuntimeException;
use Usuario\Entity\Usuario;
use Zend\Permissions\Rbac\AssertionInterface;
use Application\Repository\RepositoryAbstract;
use Doctrine\ORM\EntityManagerInterface;

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
     * Usuario Autenticado
     * @var Usuario
     */
    protected $authenticatedIdentity;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Define usuario autenticado
     *
     * @param Usuario $usuario
     * @return void
     */
    public function setAuthenticatedIdentity(Usuario $usuario)
    {
        $this->authenticatedIdentity = $usuario;
    }

    /**
     * Retorna usuario autenticado
     *
     * @return Usuario
     * @throws RuntimeException
     */
    public function getAuthenticatedIdentity()
    {
        if (!$this->authenticatedIdentity instanceof Usuario) {
            throw new RuntimeException(self::MUST_BE_LOGGED_IN_MESSAGE, self::MUST_BE_LOGGED_IN_CODE);
        }

        return $this->authenticatedIdentity;
    }

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
