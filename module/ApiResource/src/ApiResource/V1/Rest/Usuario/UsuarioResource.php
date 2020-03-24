<?php

namespace ApiResource\V1\Rest\Usuario;

use Exception;
use Usuario\Entity\Usuario;
use Usuario\Rbac\GuardedResourceInterface;
use Usuario\Rbac\RoleProvider;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Usuario\Service\UsuarioService;

class UsuarioResource extends AbstractResourceListener implements GuardedResourceInterface
{
    protected $usuarioService;

    public static function getResourceGuard()
    {
        return [
            'create' => RoleProvider::ADMIN_CREATE,
            'fetch' => RoleProvider::ADMIN_FETCH,
            'fetchAll' => RoleProvider::ADMIN_FETCH
        ];
    }

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        try {
            $usuario = new Usuario();
            $usuario->setNome($data->nome);
            $usuario->setSenha($data->senha);
            $usuario->setEmail($data->email);
            $usuario->setApelido($data->apelido);

            $response = $this->usuarioService->insertUsuario($usuario);

            return $response;
        } catch (Exception $exception) {
            return new ApiProblem(422, 'Usuário já existe');
        }
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->usuarioService->getUsuario($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->usuarioService->getUsuarios();
    }
}
