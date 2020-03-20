<?php

namespace Usuario\Service;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use RuntimeException;
use Usuario\Authentication\iAuthAwareInterface;
use Usuario\Entity\Usuario;
use Usuario\RBAC\ServiceRBAC;

class UsuarioService implements iAuthAwareInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var Usuario
     */
    protected $authenticatedIdentity;

    /**
     * @var ServiceRBAC
     */
    protected $serviceRBAC;

    const USER_ALREADY_REGISTERED_MESSAGE = 'Este usuário já está registrado.';
    const USER_ALREADY_REGISTERED_CODE = 2;
    const USER_NOT_FOUND_MESSAGE = 'Usuário não encontrado.';
    const USER_NOT_FOUND_CODE = 3;
    const MUST_BE_LOGGED_IN_MESSAGE = 'Você precisa estar autenticado para executar esta ação.';
    const MUST_BE_LOGGED_IN_CODE = 4;
    const PERMISSION_DENIED_MESSAGE = 'Você não possui permissões para executar esta ação.';
    const PERMISSION_DENIED_CODE = 5;

    public function __construct(EntityManagerInterface $entityManager, ServiceRBAC $serviceRBAC)
    {
        $this->entityManager = $entityManager;
        $this->serviceRBAC = $serviceRBAC;
        $this->serviceRBAC->getRBAC()
            ->getRole(ServiceRBAC::ROLE_ADMIN)
            ->addPermission(__CLASS__ . '::inserUsuario');
    }
    
    /**
     * {@inheritDoc}
     */
    public function setAuthenticatedIdentity(Usuario $usuario)
    {
        if (! $this->authenticatedIdentity instanceof Usuario) {
            throw new RuntimeException(self::MUST_BE_LOGGED_IN_MESSAGE, self::MUST_BE_LOGGED_IN_CODE);
        }
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

    public function isMethodAllowed($method, $assertion = null)
    {
        try {
            $usuario = $this->getAuthenticatedIdentity();

            if (! $usuario instanceof Usuario) {
                return false;
            }
            
            foreach ($$usuario->getRoles() as $role) {
                
                if ($this->serviceRBAC->getRBAC()->isGranted($role, $method, $assertion)) {
                    return true;
                }
            }
            return false;
        } catch (Exception $exception) {
            return false;
        }
    }
}
