<?php

namespace Financeiro\Entity;

use Application\Entity\EntityAbstract;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Financeiro\Repository\Banco")
 * @ORM\Table(name="banco")
 * @ORM\HasLifecycleCallbacks
 */
class Banco extends EntityAbstract
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
     * Lançamentos para o banco.
     * 
     * @ORM\OneToMany(targetEntity="Financeiro\Entity\Lancamento", fetch="EXTRA_LAZY", mappedBy="banco", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $lancamentos;

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
    public function setNome(string $nome)
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
    public function setConta(string $conta)
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
    public function setAgencia(string $agencia)
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
    public function setLancamentos(ArrayCollection $lancamentos)
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
