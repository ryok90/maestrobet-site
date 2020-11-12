<?php

namespace Financeiro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Extrato refere-se ao saldo do mês anterior ao mês corrente.
 * Usado para não ser recalculado todas as transações de um usuário
 * 
 * @ORM\Entity(repositoryClass="Financeiro\Repository\ExtratoBanco")
 * @ORM\Table(name="Financeiro_ExtratoBanco")
 * @ORM\HasLifecycleCallbacks
 */
class ExtratoBanco extends ExtratoAbstract
{
    /**
     * Lançamentos referentes ao mês corrente.
     * 
     * @ORM\OneToMany(targetEntity="Financeiro\Entity\Lancamento", fetch="EXTRA_LAZY", mappedBy="extratoBanco", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $lancamentos;

    /**
     * @ORM\ManyToOne(targetEntity="Financeiro\Entity\Banco", inversedBy="extratos", cascade={"persist"})
     * @ORM\JoinColumn(name="idBanco", referencedColumnName="id", nullable=true)
     * @var Banco
     */
    protected $banco;

    /**
     * @return ArrayCollection
     */
    public function getLancamentos()
    {
        return $this->lancamentos;
    }

    /**
     * @param ArrayCollection $lancamentos Lançamentos referentes ao mês corrente.
     */
    public function setLancamentos($lancamentos)
    {
        $this->lancamentos = $lancamentos;
    }

    /**
     * @return Banco
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * @param Banco $banco
     *
     * @return self
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'dataExtrato' => $this->getDataExtrato(),
            'lancamentos' => $this->collectionToArray($this->getLancamentos()),
            'saldo' => $this->getSaldo(),
            'banco' => $this->getBanco() ? $this->getBanco()->toArrayMin() : null
        ];
    }

    /**
     * @inheritdoc
     */
    public function toArrayMin()
    {
        return [
            'id' => $this->getId(),
            'dataExtrato' => $this->getDataExtrato(),
        ];
    }
}