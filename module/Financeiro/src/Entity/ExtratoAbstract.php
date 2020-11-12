<?php

namespace Financeiro\Entity;

use Application\Entity\EntityAbstract;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Extrato refere-se ao saldo do mês anterior ao mês corrente.
 * Usado para não ser recalculado todas as transações de um usuário
 */
abstract class ExtratoAbstract extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

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

    abstract public function getLancamentos();

    abstract public function setLancamentos($lancamentos);

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

        return $this->getDataExtrato() == $dataAtual->format('Y-m-d');
    }
}
