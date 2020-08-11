<?php

namespace Financeiro\Entity;

use Application\Entity\EntityAbstract;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Extrato refere-se ao saldo do mês anterior ao mês corrente.
 * Usado para não ser recalculado todas as transações de um usuário
 * 
 * @ORM\Entity(repositoryClass="Financeiro\Repository\Extrato")
 * @ORM\Table(name="extrato")
 * @ORM\HasLifecycleCallbacks
 */
class Extrato extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\Usuario", inversedBy="extratos", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuario", referencedColumnName="id", nullable=false)
     * @var \Usuario\Entity\Usuario
     */
    protected $usuario;

    /**
     * @ORM\Column(type="date", nullable=false)
     * @var DateTime
     */
    protected $dataExtrato;

    /**
     * Saldo até o mês atual.
     * Salto total é calculo utilizando este valor mais os lançamentos do mês corrente
     * 
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=false)
     * @var float
     */
    protected $saldo;

    /**
     * Lançamentos referentes ao mês corrente.
     * 
     * @ORM\OneToMany(targetEntity="Financeiro\Entity\Lancamento", fetch="EXTRA_LAZY", mappedBy="extrato", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $lancamentos;

    public function __construct()
    {
        $this->lancamentos = new ArrayCollection();
        $this->setDataExtrato(new DateTime('midnight first day of'));
    }

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
     * @return \Usuario\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param \Usuario\Entity\Usuario $usuario 
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return DateTime
     */
    public function getDataExtrato($format = "Y-m-d")
    {
        if ($this->dataExtrato instanceof DateTime) {

            return $this->dataExtrato->format($format);
        }
        
        return $this->dataExtrato;
    }

    /**
     * @param DateTime $dataExtrato 
     */
    public function setDataExtrato($dataExtrato)
    {
        $this->dataExtrato = $dataExtrato;
    }

    /**
     * @return float
     */
    public function getSaldo()
    {
        return (float) $this->saldo;
    }

    /**
     * @param float $saldo 
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;
    }

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
     * Calcula o total dos lançamentos vinculados ao extrato.
     * @return float
     */
    public function totalLancamentos()
    {
        $total = 0;

        foreach ($this->getLancamentos() as $lancamento) {
            if ($lancamento->getStatus() == 1) {
                $total += $lancamento->getValor();
            }
        }

        return $total;
    }

    /**
     * Calcula o saldo total atual com os lançamentos do mês corrente.
     * @return void
     */
    public function saldoTotalAtual()
    {
        return $this->getSaldo() + $this->totalLancamentos();
    }

    public function isExtratoAtual()
    {
        $dataAtual = new DateTime('first day of');

        return $this->getDataExtrato() != $dataAtual;
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
            'usuario' => $this->getUsuario() ? $this->getUsuario()->toArrayMin() : null
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
