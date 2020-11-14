<?php

namespace Financeiro\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Financeiro\Repository\Banco")
 * @ORM\Table(name="Financeiro_Banco")
 * @ORM\HasLifecycleCallbacks
 */
class Banco extends ContaAbstract
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * Nome do Banco
     * 
     * @ORM\Column(name="nome", type="string", nullable=false, length=64)
     * @var string
     */
    protected $nome;

    /**
     * Conta
     * 
     * @ORM\Column(name="conta", type="string", nullable=false, length=64)
     * @var string
     */
    protected $conta;

    /**
     * Agencia
     * 
     * @ORM\Column(name="agencia", type="string", nullable=false, length=64)
     * @var string
     */
    protected $agencia;

    /**
     * Todos os extratos mensais.
     * Extratos possuem saldo que refere à soma dos lançamentos até seu mês corrente.
     * 
     * @ORM\OneToMany(targetEntity="Financeiro\Entity\ExtratoBanco", fetch="EXTRA_LAZY", mappedBy="banco", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $extratos;

    /**
     * Último extrato cadastrado.
     * 
     * @ORM\OneToOne(targetEntity="Financeiro\Entity\ExtratoBanco", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\JoinColumn(name="idExtrato", referencedColumnName="id", nullable=true)
     * @var Extrato
     */
    protected $extrato;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get nome do Banco
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set nome do Banco
     *
     * @param string $nome Nome do Banco
     *
     * @return self
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get conta
     *
     * @return string
     */ 
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * Set conta
     *
     * @param string $conta Conta
     *
     * @return self
     */ 
    public function setConta($conta)
    {
        $this->conta = $conta;

        return $this;
    }

    /**
     * Get agencia
     *
     * @return string
     */ 
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * Set agencia
     *
     * @param string $agencia Agencia
     *
     * @return self
     */ 
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;

        return $this;
    }

    /**
     * Get lançamentos para o banco.
     *
     * @return ArrayCollection
     */
    public function getLancamentos()
    {
        return $this->lancamentos;
    }

    /**
     * Set lançamentos para o banco.
     *
     * @param ArrayCollection $lancamentos Lançamentos para o banco.
     *
     * @return self
     */
    public function setLancamentos($lancamentos)
    {
        $this->lancamentos = $lancamentos;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'agencia' => $this->getAgencia(),
            'conta' => $this->getConta(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function toArrayMin()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
        ];
    }
}
