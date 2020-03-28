<?php

namespace ApiResource\V1\Rest\Usuario;

use Exception;
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
        try {
            $data = $this->getInputFilter()->getValues();
            $usuario = $this->getHydrator()->hydrate($data, new Usuario());
            $response = $this->service->insert($usuario);

            return $response;
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao inserir usuário');
        }
    }

    public function patch($id, $rawData)
    {
        try {
            $usuarioRepo = $this->getRepository(Usuario::class);
            $usuario = $usuarioRepo->getActiveResult($id);

            if (!$usuario instanceof Usuario) {

                return new ApiProblem(404, 'Usuário não encontrado');
            }
            $data = $this->getInputFilter()->getValues();
            $usuario = $this->getHydrator()->hydrate($data, $usuario);

            return $this->service->update($usuario);
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao atualizar usuário');
        }
    }

    public function delete($id)
    {
        try {
            $usuarioRepo = $this->getRepository(Usuario::class);
            $usuario = $usuarioRepo->getActiveResult($id);

            if (!$usuario instanceof Usuario) {

                return new ApiProblem(404, 'Usuário não encontrado');
            }
            $usuario->logicalDelete();

            return $this->service->delete($usuario);
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao remover usuário');
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
        try {
            $usuarioRepo = $this->getRepository(Usuario::class);
            $usuario = $usuarioRepo->getActiveResult($id);

            if (!$usuario instanceof Usuario) {

                return new ApiProblem(404, 'Usuário não encontrado');
            }

            return $usuario;
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao recuperar usuário');
        }
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        try {
            $usuarioRepo = $this->service->getRepository(Usuario::class);
            $usuarios = $usuarioRepo->getActiveResults();

            foreach ($usuarios as $usuario) {
                $usuario->setExtrato($usuario->getExtrato()->saldoTotalAtual());
            }
            
            return $usuarios;
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao recuperar usuários');
        }
    }
}
