<?php

namespace ApiResource\V1\Rest\Lancamento;

use Application\RestResource\RestResourceAbstract;
use Exception;
use Financeiro\Entity\Lancamento;
use Usuario\Rbac\GuardedResourceInterface;
use Usuario\Rbac\RoleProvider;
use ZF\ApiProblem\ApiProblem;
use Financeiro\Service\LancamentoService;

class LancamentoResource extends RestResourceAbstract implements GuardedResourceInterface
{
    /**
     * Declarado somente pela Annotation
     * @var LancamentoService
     */
    protected $service;

    public static function getResourceGuard()
    {
        return [
            'create' => RoleProvider::ADMIN_CREATE,
            'fetch' => [RoleProvider::USUARIO_FETCH_SELF, RoleProvider::ADMIN_FETCH],
            'fetchAll' => [RoleProvider::USUARIO_FETCH_SELF, RoleProvider::ADMIN_FETCH],
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
            $hydrator = $this->getHydrator();
            $lancamento = $hydrator->hydrate($data, new Lancamento());

            return $this->service->insert($lancamento);
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao registrar lançamento');
        }
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        try {
            $lancamentoRepo = $this->getRepository();
            $lancamento = $lancamentoRepo->getActiveResult($id);
            $lancamento->logicalDelete();

            return $this->service->delete($lancamento);
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao remover lançamento');
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
            $usuarioId = $this->getRouteParam('usuario_id');
            $lancamento = $this->getRepository()->getLancamentoPorUsuario($id, $usuarioId);

            if (!$lancamento instanceof Lancamento) {

                return new ApiProblem(404, 'Lançamento não encontrado');
            }

            return $lancamento;
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao recuperar lançamento');
        }
    }

    public function fetchAll($params = [])
    {
        try {
            $usuarioId = $this->getRouteParam('usuario_id');

            return $this->getRepository()->getLancamentosPorUsuario($usuarioId);
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao recuperar lançamentos');
        }
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
        try {
            $lancamento = $this->getRepository()->getActiveResult($id);

            if (!$lancamento instanceof Lancamento) {

                return new ApiProblem(404, 'Lançamento não encontrado');
            }
            $data = $this->getInputFilter()->getValues();
            $hydrator = $this->getHydrator();
            $lancamento = $hydrator->hydrate($data, $lancamento);

            return $this->service->patch($lancamento);
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao atualizar lançamento');
        }
    }
}
