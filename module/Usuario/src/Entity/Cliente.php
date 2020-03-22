<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\EntityAbstract;

/**
 * @ORM\Entity
 * @ORM\Table(name="cliente")
 */
class Cliente extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\Column(name="idCliente", type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $idCliente;
}
