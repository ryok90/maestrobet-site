<?php

namespace ApiResource\V1\Rest\Lancamento;

use Application\RestResource\RestResourceAbstract;
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
        /** @var Lancamento $lancamento */
        $lancamento = $this->getHydratedObject(new Lancamento());
        $lancamento->updateResponsavel();
        $lancamento->updateExtratos();
        $result = $this->service->insert($lancamento);

        return $result->toArray();
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($idLancamento)
    {
        $lancamentoRepo = $this->getRepository();
        $idUsuario = $this->getRouteParam('usuario_id');
        $lancamento = $lancamentoRepo->getLancamentoPorUsuario($idLancamento, $idUsuario);

        if (!$lancamento instanceof Lancamento) {

            return new ApiProblem(404, 'Lançamento não encontrado');
        }

        return $this->service->delete($lancamento);
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($idLancamento)
    {
        $idUsuario = $this->getRouteParam('usuario_id');
        $lancamento = $this->getRepository()->getLancamentoPorUsuario($idLancamento, $idUsuario);

        if (!$lancamento instanceof Lancamento) {

            return new ApiProblem(404, 'Lançamento não encontrado');
        }

        return $lancamento->toArray();
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
        $lancamento = $this->getRepository()->getActiveResult($id);

        if (!$lancamento instanceof Lancamento) {

            return new ApiProblem(404, 'Lançamento não encontrado');
        }
        $data = $this->getInputFilter()->getValues();
        $hydrator = $this->getHydrator();
        $lancamento = $hydrator->hydrate($data, $lancamento);
        $lancamento = $this->service->patch($lancamento);

        return $lancamento->toArray();
    }
}
