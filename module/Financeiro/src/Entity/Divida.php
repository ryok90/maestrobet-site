<?php

namespace Financeiro\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\EntityAbstract;

/**
 * @ORM\Entity
 * @ORM\Table(name="divida")
 */
class Divida extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\Column(name="idDivida", type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $idDivida;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\Usuario")
     * @ORM\JoinColumn(name="idUsuario", referencedColumnName="id", nullable=false)
     * @var Usuario\Entity\Usuario
     */
    protected $usuario;

    /**
     * @ORM\Column(name="valor", type="decimal", precision=11, scale=2, nullable=false)
     * @var float
     */
    protected $valor;
}