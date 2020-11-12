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
     * @return ExtratoAbstract
     */
    public function getExtrato()
    {
        return $this->extrato;
    }

    /**
     * @param ExtratoAbstract $extrato Último extrato cadastrado.
     */
    public function setExtrato($extrato)
    {
        $this->extrato = $extrato;
    }


    /**
     * Recupera o Extrato atual. Se não houver Extrato atual ou se o Extrato
     * não for o atual, gera-se um novo extrato.
     * @return ExtratoAbstract
     */
    public function getExtratoAtual()
    {
        $semExtratoAtual = is_null($this->extrato) || !$this->extrato->isExtratoAtual();

        if ($semExtratoAtual) {
            $usuarioCriador = $this;

            if ($this instanceof Banco) {
                $usuarioCriador = $this->getUsuarioCriador();
            }

            return $this->gerarNovoExtrato($usuarioCriador);
        }

        return $this->extrato;
    }
    /**
     * @return float
     */
    public function saldoTotalAtual()
    {
        if ($this->getExtrato() instanceof ExtratoAbstract) {

            return $this->getExtrato()->saldoTotalAtual();
        }

        return 0.0;
    }

    /**
     * Gera um novo extrato baseado no extrato anterior
     * @param Usuario $usuarioCriador
     * @return ExtratoAbstract
     */
    public function gerarNovoExtrato($usuarioCriador)
    {
        if ($this instanceof Banco) {
            return $this->gerarExtratoBanco($usuarioCriador);
        }

        if ($this instanceof Usuario) {
            return $this->gerarExtratoUsuario($usuarioCriador);
        }
    }

    protected function gerarExtratoBanco($usuarioCriador)
    {
        $novoExtrato = new ExtratoBanco();
        $novoExtrato->setSaldo($this->saldoTotalAtual());
        $novoExtrato->setUsuarioCriador($usuarioCriador);
        $novoExtrato->setDataExtrato(new DateTime('first day of'));
        $novoExtrato->setBanco($this);
        $this->setExtrato($novoExtrato);

        return $this->getExtrato();
    }

    protected function gerarExtratoUsuario($usuarioCriador)
    {
        $novoExtrato = new ExtratoUsuario();
        $novoExtrato->setSaldo($this->saldoTotalAtual());
        $novoExtrato->setUsuarioCriador($usuarioCriador);
        $novoExtrato->setDataExtrato(new DateTime('first day of'));
        $novoExtrato->setUsuario($this);

        $this->setExtrato($novoExtrato);

        return $this->getExtrato();
    }
}