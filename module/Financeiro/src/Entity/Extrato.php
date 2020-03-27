<?php

namespace Financeiro\Entity;

use Application\Entity\EntityAbstract;
use DateTime;
use Zend\Db\Sql\Ddl\Column\Date;

/**
 * Extrato refere-se ao total do mês anterior ao mês corrente
 * Usado para não ser recalculado todas as transações de um usuário
 * 
 * @ORM\Entity
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
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\Usuario", mappedBy="extratos", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuario", referencedColumnName="id", nullable=false)
     * @var \Usuario\Entity\Usuario
     */
    protected $usuario;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var DateTime
     */
    protected $dataExtrato;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=false)
     * @var float
     */
    protected $total;

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
    public function getTotal()
    {
        return (float) $this->total;
    }

    /**
     * @param float $total 
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }
}
