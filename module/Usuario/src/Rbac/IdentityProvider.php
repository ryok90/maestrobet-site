<?php

namespace Usuario\Rbac;

use Doctrine\ORM\EntityManager;
use Usuario\Entity\Usuario;
use Zend\Authentication\AuthenticationService;
use ZfcRbac\Identity\IdentityProviderInterface;

/**
 * Fornece objeto de Usuario logado ou convidado ao AuthenticationService
 */
class IdentityProvider implements IdentityProviderInterface
{
    /**
     * @var Usuario|null
     */
    private $identity = null;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(AuthenticationService $authenticationService, EntityManager $entityManager)
    {
        $this->authenticationService = $authenticationService;
        $this->entityManager = $entityManager;
    }

    /**
     * Faz a conversão de AuthenticatedIdentity para Usuario logado ou 
     * GuestIdentity para um new Usuario
     * 
     * @todo rever se é necessário retornar new Usuario para id não encontrados
     * @return Usuario
     */
    public function getIdentity()
    {
        if ($this->identity instanceof Usuario) {

            return $this->identity;
        }
        $idUsuario = $this->authenticationService->getIdentity()->getRoleId();
        $this->identity = $this->entityManager->find(Usuario::class, $idUsuario);

        if (!$this->identity instanceof Usuario) {
            $this->identity = new Usuario();
        }

        return $this->identity;
    }
}
