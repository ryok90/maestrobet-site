<?php

namespace Financeiro\Service;

use Application\Exception\ApiGeneralException;
use Application\Service\ServiceAbstract;
use Exception;
use Financeiro\Entity\Banco;
use ZF\ApiProblem\ApiProblem;
use Financeiro\Entity\Lancamento;
use Usuario\Entity\Usuario;

class LancamentoService extends ServiceAbstract
{
    /**
     * @param Lancamento $lancamento
     * @return Lancamento|ApiProblem
     */
    public function insert($lancamento)
    {
        try {
            if ($lancamento->getId()) {

                return new ApiProblem(400, 'Lançamento já registrado');
            }
            $lancamento->setUsuarioCriador($this->getUsuarioAutenticado());
            $this->entityManager->persist($lancamento);
            $this->entityManager->flush();
            $this->refreshDependencies($lancamento);

            return $lancamento;
        } catch (Exception $exception) {
            throw new ApiGeneralException('Ocorreu um erro ao inserir o lançamento', 500, $exception);
        }
    }

    /**
     * @param Lancamento $lancamento
     * @return Lancamento|ApiProblem
     */
    public function patch($lancamento)
    {
        try {
            if (!$lancamento->getId()) {

                return new ApiProblem(400, 'Lançamento não encontrado');
            }
            $this->entityManager->persist($lancamento);
            $this->entityManager->flush();

            return $lancamento;
        } catch (Exception $exception) {
            throw new ApiGeneralException('Ocorreu um erro ao atualizar o lançamento', 500, $exception);
        }
    }

    /**
     * @param Lancamento $lancamento
     * @return bool|ApiProblem
     */
    public function delete($lancamento)
    {
        try {
            if (!$lancamento->getId()) {

                return new ApiProblem(400, 'Lançamento não encontrado');
            }
            $lancamento->logicalDelete();
            $this->entityManager->persist($lancamento);
            $this->entityManager->flush();

            return true;
        } catch (Exception $exception) {
            throw new ApiGeneralException('Ocorreu um erro ao remover o lançamento', 500, $exception);
        }
    }


    /**
     * Atualiza as dependencias de lançamento
     * Usuario ou Banco
     * @param Lancamento $lancamento
     * @return void
     */
    protected function refreshDependencies($lancamento)
    {
        try {
            if ($lancamento->getUsuario() instanceof Usuario) {
                return $this->entityManager->refresh($lancamento->getUsuario());
            }

            if ($lancamento->getBanco() instanceof Banco) {
                return $this->entityManager->refresh($lancamento->getBanco());
            }
        } catch (Exception $exception) {}
    }
}
