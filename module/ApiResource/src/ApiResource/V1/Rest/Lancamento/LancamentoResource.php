<?php

namespace ApiResource\V1\Rest\Lancamento;

use Application\RestResource\RestResourceAbstract;
use DateTime;
use Exception;
use Financeiro\Entity\Extrato;
use Financeiro\Entity\Lancamento;
use Usuario\Rbac\GuardedResourceInterface;
use Usuario\Rbac\RoleProvider;
use ZF\ApiProblem\ApiProblem;
use Financeiro\Service\LancamentoService;
use Usuario\Entity\Usuario;

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
        try {
            $data = $this->getInputFilter()->getValues();
            $hydrator = $this->getHydrator();
            $lancamento = $hydrator->hydrate($data, new Lancamento());
            $idUsuario = $this->getRouteParam('usuario_id');

            /** @var Usuario $usuario */
            $usuario = $this->getRepository(Usuario::class)->getActiveResult($idUsuario);
            $extrato = $usuario->getExtrato();
            $dataExtratoAtual = new DateTime('first day of');

            /** Extrato desatualizado */
            if ($extrato->getDataExtrato() != $dataExtratoAtual->format('Y-m-d')) {
                $extrato = $usuario->gerarNovoExtrato($this->getIdentity());
            }
            $lancamento->setExtrato($extrato);
            $lancamento->setUsuario($usuario);

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
    public function delete($idLancamento)
    {
        try {
            $lancamentoRepo = $this->getRepository();
            $idUsuario = $this->getRouteParam('usuario_id');
            $lancamento = $lancamentoRepo->getLancamentoPorUsuario($idLancamento, $idUsuario);

            if (!$lancamento instanceof Lancamento) {

                return new ApiProblem(404, 'Lançamento não encontrado');
            }
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
    public function fetch($idLancamento)
    {
        try {
            $idUsuario = $this->getRouteParam('usuario_id');
            $lancamento = $this->getRepository()->getLancamentoPorUsuario($idLancamento, $idUsuario);

            if (!$lancamento instanceof Lancamento) {

                return new ApiProblem(404, 'Lançamento não encontrado');
            }

            return $lancamento;
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao recuperar lançamento');
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
