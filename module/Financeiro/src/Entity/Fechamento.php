<?php 

namespace Financeiro\Entity;

use Application\Entity\EntityAbstract;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fechamento")
 */
class Fechamento extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\Column(name="idFechamento", type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $idFechamento;

    /**
     * Número da semana a qual o Fechamento pertence
     * Ex: semana 2 de 2020 refere-se a semana do dia 06 de janeiro (segunda-feira)
     * até o dia 12 de janeiro (domingo)
     * 
     * @ORM\Column(name="semana", type="integer")
     * @var int
     */
    protected $semana;
}
