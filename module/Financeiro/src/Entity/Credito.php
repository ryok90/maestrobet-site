<?php

namespace Financeiro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="credito")
 */
class Credito extends LancamentoAbstract
{
    /**
     * @ORM\Id
     * @ORM\Column(name="idCredito", type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $idCredito;

    /**
     * @return int
     */
    public function getIdCredito()
    {
        return $this->idCredito;
    }

    /**
     * @param int $idCredito 
     */
    public function setIdCredito($idCredito)
    {
        $this->idCredito = $idCredito;
    }
}
