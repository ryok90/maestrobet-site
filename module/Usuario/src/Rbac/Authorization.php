<?php

namespace Usuario\Rbac;

use Error;
use Exception;
use ZF\ApiProblem\ApiProblem;
use ZF\MvcAuth\Authorization\AuthorizationInterface;
use ZfcRbac\Service\AuthorizationService;
use ZF\MvcAuth\Identity\IdentityInterface;

/**
 * Classe de autorização que sobrescreve MvcAuth\Authorization
 * Configurações de Rest Guard ficam em config/autoload/zfc_rbac.global.php
 * Configurações de Roles e Permissions ficam na entity de Usuario
 */
class Authorization implements AuthorizationInterface
{
    /**
     * @var AuthorizationService
     */
    private $authorizationService;

    private $config;

    public function __construct(AuthorizationService $authorizationService, array $config)
    {
        $this->authorizationService = $authorizationService;
        $this->config = $config;
    }

    /**
     * Método responsável pela autenticação geral do usuário/convidado
     * 
     * @param \ZF\MvcAuth\Identity\IdentityInterface $identity
     * @param string $resource
     * @param string $privilege
     * @return bool
     */
    public function isAuthorized(IdentityInterface $identity, $resource, $privilege)
    {
        $restGuard = $this->config['rest_guard'];
        list($class, $group) = explode('::', $resource);

        $allowedRoles = $restGuard[$class][$group][$privilege] ?? null;

        /** Caso em que não foram adicionadas as permissões no zfc_rbac.global.php */
        if (is_null($allowedRoles)) {

            return false;
        }

        /** 
         * Caso em que é um array de Roles. 
         * Nesse caso, se usuário possui ao menos 1 Role compatível, o acesso é permitido
         */
        if (is_array($allowedRoles)) {

            foreach ($allowedRoles as $allowedRole) {

                if ($this->authorizationService->isGranted($allowedRole)) {

                    return true;
                }
            }
            /** Retorno caso nenhuma permissão que o usuário possui satifaça */
            return false;
        }
        /** Retorno caso a requisição tenha permissão absoluta (boolean) */
        return $allowedRoles;
    }
}
