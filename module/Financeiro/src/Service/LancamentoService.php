<?php

namespace Financeiro\Service;

use Application\Service\ServiceAbstract;
use ZF\ApiProblem\ApiProblem;
use Financeiro\Entity\Lancamento;

class LancamentoService extends ServiceAbstract
{
    /**
     * @param Lancamento $lancamento
     * @return Lancamento|ApiProblem
     */
    public function insert($lancamento)
    {
        if ($lancamento->getId()) {

            return new ApiProblem(400, 'Lançamento já registrado');
        }
        $lancamento->setUsuarioCriador($this->getUsuarioAutenticado());
        $this->entityManager->persist($lancamento);
        $this->entityManager->flush();

        return $lancamento;
    }

    /**
     * @param Lancamento $lancamento
     * @return Lancamento|ApiProblem
     */
    public function patch($lancamento)
    {
        if (!$lancamento->getId()) {

            return new ApiProblem(400, 'Lançamento não encontrado');
        }
        $this->entityManager->persist($lancamento);
        $this->entityManager->flush();

        return $lancamento;
    }

    /**
     * @param Lancamento $lancamento
     * @return bool|ApiProblem
     */
    public function delete($lancamento)
    {
        if (!$lancamento->getId()) {
            
            return new ApiProblem(400, 'Lançamento não encontrado');
        }
        $this->entityManager->persist($lancamento);
        $this->entityManager->flush();

        return true;
    }
}
