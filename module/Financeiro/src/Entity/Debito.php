<?php

namespace Financeiro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="debito")
 */
class Debito extends LancamentoAbstract
{
    /**
     * @ORM\Id
     * @ORM\Column(name="idDebito", type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $idDebito;

    /**
     * @return int
     */
    public function getIdDebito()
    {
        return $this->idDebito;
    }

    /**
     * @param int $idDebito 
     */
    public function setIdDebito($idDebito)
    {
        $this->idDebito = $idDebito;
    }
}
