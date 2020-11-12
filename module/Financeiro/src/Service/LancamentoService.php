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
        if ($lancamento->getId()) {
            throw new ApiGeneralException(400, 'Lançamento já registrado');
        }

        try {
            $lancamento->setUsuarioCriador($this->getUsuarioAutenticado());
            $this->entityManager->persist($lancamento);
            $this->entityManager->flush();
            $this->refreshDependencies($lancamento);

            return $lancamento;
        } catch (Exception $exception) {
            throw new ApiGeneralException(500, 'Ocorreu um erro ao inserir o lançamento', $exception);
        }
    }

    /**
     * @param Lancamento $lancamento
     * @return Lancamento|ApiProblem
     */
    public function patch($lancamento)
    {
        if (!$lancamento->getId()) {
            throw new ApiGeneralException(400, 'Lançamento não encontrado');
        }

        try {
            $this->entityManager->persist($lancamento);
            $this->entityManager->flush();

            return $lancamento;
        } catch (Exception $exception) {
            throw new ApiGeneralException(500,'Ocorreu um erro ao atualizar o lançamento', $exception);
        }
    }

    /**
     * @param Lancamento $lancamento
     * @return bool|ApiProblem
     */
    public function delete($lancamento)
    {
        if (!$lancamento->getId()) {
            throw new ApiGeneralException(400, 'Lançamento não encontrado');
        }

        try {
            $lancamento->logicalDelete();
            $this->entityManager->persist($lancamento);
            $this->entityManager->flush();

            return true;
        } catch (Exception $exception) {
            throw new ApiGeneralException(500,'Ocorreu um erro ao remover o lançamento', $exception);
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
                return $this->entityManager->refresh($lancamento->getExtratoUsuario());
            }

            if ($lancamento->getBanco() instanceof Banco) {
                return $this->entityManager->refresh($lancamento->getExtratoBanco());
            }
        } catch (Exception $exception) {}
    }
}
