<?php

namespace ApiResource\V1\Rest\Extrato;

use Application\RestResource\RestResourceAbstract;
use Exception;
use Financeiro\Entity\Extrato;
use Usuario\Rbac\GuardedResourceInterface;
use Usuario\Rbac\RoleProvider;
use ZF\ApiProblem\ApiProblem;

class ExtratoResource extends RestResourceAbstract implements GuardedResourceInterface
{
    public static function getResourceGuard()
    {
        return [
            'fetch' => [RoleProvider::USUARIO_FETCH_SELF, RoleProvider::ADMIN_FETCH],
            'fetchAll' => [RoleProvider::USUARIO_FETCH_SELF, RoleProvider::ADMIN_FETCH],
        ];
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
            $idUsuario = $this->getRouteParam('usuario_id');
            $extrato = $this->getRepository()->getExtratoPorUsuario($id, $idUsuario);

            if (!$extrato instanceof Extrato) {
                
                return new ApiProblem(404, 'Extrato não encontrado');
            }

            return $extrato;
        } catch (Exception $exception) {

            return new ApiProblem(500, 'Ocorreu um erro ao recuperar extrato');
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
            $idUsuario = $this->getRouteParam('usuario_id');

            return $this->getRepository()->getExtratosPorUsuario($idUsuario);
        } catch (Exception $exception) {
            
            return new ApiProblem(500, 'Ocorreu um erro ao recuperar extratos');
        }
    }
}
