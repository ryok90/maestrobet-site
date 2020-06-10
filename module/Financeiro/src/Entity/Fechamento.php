<?php 

namespace Financeiro\Entity;

use Application\Entity\EntityAbstract;
use Doctrine\ORM\Mapping as ORM;
use Financeiro\Entity\Lancamento;

/**
 * @ORM\Entity
 * @ORM\Table(name="fechamento")
 * @ORM\HasLifecycleCallbacks
 */
class Fechamento extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\Usuario")
     * @ORM\JoinColumn(name="idUsuario", referencedColumnName="id", nullable=false)
     * @var Usuario
     */
    protected $usuario;

    /**
     * Número da semana a qual o Fechamento pertence
     * Ex: semana 2 de 2020 refere-se a semana do dia 06 de janeiro (segunda-feira)
     * até o dia 12 de janeiro (domingo)
     * 
     * @ORM\Column(name="semana", type="integer")
     * @var int
     */
    protected $semana;

    /**
     * @ORM\OneToOne(targetEntity="Financeiro\Entity\Lancamento", mappedBy="fechamento", cascade={"persist"})
     * @var Lancamento
     */
    protected $lancamento;

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
     * @return int
     */
    public function getSemana()
    {
        return $this->semana;
    }

    /**
     * @param int $semana
     */
    public function setSemana($semana)
    {
        $this->semana = $semana;
    }

    /**
     * @return Lancamento
     */
    public function getLancamento()
    {
        return $this->lancamento;
    }

    /**
     * @param Lancamento $lancamento 
     */
    public function setLancamento($lancamento)
    {
        $this->lancamento = $lancamento;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario 
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'lancamento' => $this->getLancamento() ? $this->getLancamento()->toArrayMin() : null,
            'semana' => $this->getSemana(),
            'usuario' => $this->getUsuario() ? $this->getUsuarioCriador()->toArrayMin() : null,
        ];
    }

    public function toArrayMin()
    {
        return [
            'id' => $this->getId()
        ];
    }
}
