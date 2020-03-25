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
            $usuario = new Usuario($data);
            $response = $this->usuarioService->insertUsuario($usuario);

            return $response;
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao inserir usuário');
        }
    }

    public function patch($id, $data)
    {
        try {
            $usuario = $this->usuarioService->getUsuario($id);

            if (!$usuario instanceof Usuario) {

                return new ApiProblem(404, 'Usuário não encontrado');
            }
            $usuario->patch($data);
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao atualizar usuário');
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
