<?php

namespace Financeiro\Entity;

use Application\Entity\EntityAbstract;
use DateTime;
use Usuario\Entity\Usuario;

/**
 * Abstração usada para Usuario e Banco somente.
 * Ambos possuem as propriedades $extratos e $extrado com suas
 * devidas annotations de doctrine.
 */
abstract class ContaAbstract extends EntityAbstract
{
    /**
     * @return ArrayCollection
     */
    public function getExtratos()
    {
        return $this->extratos;
    }

    /**
     * @param ArrayCollection $extratos
     */
    public function setExtratos($extratos)
    {
        $this->extratos = $extratos;
    }

    /**
     * @return Extrato
     */
    public function getExtrato()
    {
        return $this->extrato;
    }

    /**
     * Recupera o Extrato atual. Se não houver Extrato atual ou se o Extrato
     * não for o atual, gera-se um novo extrato.
     * @return Extrato
     */
    public function getExtratoAtual()
    {
        $semExtratoAtual = is_null($this->extrato) || !$this->extrato->isExtratoAtual();

        if ($semExtratoAtual) {
            return $this->gerarNovoExtrato($this);
        }

        return $this->extrato;
    }

    /**
     * @param Extrato $extrato Último extrato cadastrado.
     */
    public function setExtrato($extrato)
    {
        $this->extrato = $extrato;
    }

    /**
     * @return float
     */
    public function saldoTotalAtual()
    {
        if ($this->getExtrato() instanceof Extrato) {

            return $this->getExtrato()->saldoTotalAtual();
        }

        return 0.0;
    }

    /**
     * Gera um novo extrato baseado no extrato anterior
     * @param Usuario $usuarioCriador
     * @return Extrato
     */
    public function gerarNovoExtrato($usuarioCriador)
    {
        $novoExtrato = new Extrato();
        $novoExtrato->setSaldo($this->saldoTotalAtual());
        $novoExtrato->setUsuarioCriador($usuarioCriador);
        $novoExtrato->setDataExtrato(new DateTime('first day of'));

        if ($this instanceof Usuario) {
            $novoExtrato->setUsuario($this);
        }

        if ($this instanceof Banco) {
            $novoExtrato->setBanco($this);
        }
        $this->setExtrato($novoExtrato);

        return $this->getExtrato();
    }
}