<?php

namespace ApiResource\V1\Rest\Usuario;

use Application\RestResource\RestResourceAbstract;
use Usuario\Entity\Usuario;
use Usuario\Rbac\GuardedResourceInterface;
use Usuario\Rbac\RoleProvider;
use Usuario\Service\UsuarioService;
use ZF\ApiProblem\ApiProblem;

class UsuarioResource extends RestResourceAbstract implements GuardedResourceInterface
{
    /**
     * @var UsuarioService $service
     */
    protected $service;

    public static function getResourceGuard()
    {
        return [
            'create' => RoleProvider::ADMIN_CREATE,
            'fetch' => RoleProvider::ADMIN_FETCH,
            'fetchAll' => RoleProvider::ADMIN_FETCH,
            'patch' => RoleProvider::ADMIN_PATCH,
            'delete' => RoleProvider::ADMIN_DELETE,
        ];
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($rawData)
    {
        /** @var Usuario $usuario */
        $usuario = $this->getHydratedObject(new Usuario());
        $usuario = $this->service->insert($usuario);

        return $usuario->toArray();
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $rawData)
    {
        $usuarioRepo = $this->getRepository(Usuario::class);
        $usuario = $usuarioRepo->getActiveResult($id);

        if (!$usuario instanceof Usuario) {

            return new ApiProblem(404, 'Usuário não encontrado');
        }
        $data = $this->getInputFilter()->getValues();
        $usuario = $this->getHydrator()->hydrate($data, $usuario);
        $usuario = $this->service->update($usuario);

        return $usuario->toArray();
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $usuarioRepo = $this->getRepository(Usuario::class);
        $usuario = $usuarioRepo->getActiveResult($id);

        return $this->service->delete($usuario);
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $usuarioRepo = $this->getRepository(Usuario::class);
        $usuario = $usuarioRepo->getActiveResult($id);

        return $usuario->toArray();
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $usuarioRepo = $this->service->getRepository(Usuario::class);
        $usuarios = $usuarioRepo->getActiveResults();

        return $this->collectionToArray($usuarios);
    }
}
