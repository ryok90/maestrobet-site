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
use Usuario\Repository\Usuario as UsuarioRepository;

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

            /** @var UsuarioRepository $usuarioRepo */
            $usuarioRepo = $this->getRepository(Usuario::class);

            /** @var Usuario $usuario */
            $usuario = $usuarioRepo->getActiveResult($idUsuario);

            if (!$usuario instanceof Usuario) {
                return new ApiProblem(404, 'Usuario não encontrado');
            }
            $extrato = $usuario->getExtratoAtual();
            $lancamento->setExtrato($extrato);
            $lancamento->setUsuario($usuario);
            $lancamento = $this->service->insert($lancamento);

            return $usuario->toArray();
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
            $lancamento = $this->service->delete($lancamento);

            return true;
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

            return $lancamento->toArray();
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
            $lancamento = $this->service->patch($lancamento);

            return $lancamento->toArray();
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao atualizar lançamento');
        }
    }
}
