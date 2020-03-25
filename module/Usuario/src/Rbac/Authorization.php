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
    protected $authorizationService;

    protected $config;

    const METHOD_CONVERSION = [
        'collection' => [
            'GET' => 'fetchAll',
            'POST' => 'create',
            'PUT' => 'replaceList',
            'PATCH' => 'patchList',
            'DELETE' => 'deleteList'
        ],
        'entity' => [
            'GET' => 'fetch',
            'PUT' => 'update',
            'PATCH' => 'patch',
            'DELETE' => 'delete'
        ]
    ];

    public function __construct(AuthorizationService $authorizationService, array $config)
    {
        $this->authorizationService = $authorizationService;
        $this->config = $config;
    }

    /**
     * Método responsável pela autorização geral do usuário/convidado
     * 
     * @param \ZF\MvcAuth\Identity\IdentityInterface $identity
     * @param string $request Ex: Application\Controller\IndexController::index
     * @param string $privilege Ex: GET
     * @return bool
     */
    public function isAuthorized(IdentityInterface $identity, $request, $privilege)
    {
        list($controller, $group) = explode('::', $request);
        $restConfig = $this->config['zf-rest'];
        $resourceName = $restConfig[$controller]['listener'] ?? '';

        /** 
         * Caso em que o controller não pertence a Api
         * @todo Implementar casos em que não seja da Api
         */
        if (!class_exists($resourceName)) {

            return true;
        }
        $interfaces = class_implements($resourceName);

        /**
         * Caso em que o Resource em questão não implementa a interface de permissão
         * @todo Revisar como tratar a resposta nesse caso
         */
        if (!in_array(GuardedResourceInterface::class, $interfaces)) {

            return true;
        }
        $requestedMethod = self::METHOD_CONVERSION[$group][$privilege];
        $guard = $resourceName::getResourceGuard();
        $permission = $guard[$requestedMethod] ?? false;

        /**
         * Caso em que há somente uma permissão implementada ao método
         */
        if (is_string($permission)) {

            return $this->authorizationService->isGranted($permission);
        }

        /**
         * Caso em que há um array de permissões
         * Se a Role possuir ao menos uma das permissões, o acesso é concedido
         */
        if (is_array($permission)) {

            foreach ($permission as $perm) {
                
                if ($this->authorizationService->isGranted($perm)) {
                    return true;
                }
            }
            
            return false;
        }

        /**
         * Caso em que a permissão é absoluta (boolean)
         * Permite qualquer acesso ou não permite nenhum
         */
        return $permission;
    }
}
