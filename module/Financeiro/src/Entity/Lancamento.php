<?php

namespace Financeiro\Entity;

use Usuario\Entity\Usuario;
use Application\Entity\EntityAbstract;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Financeiro\Entity\Fechamento;

/**
 * @ORM\Entity
 * @ORM\Table(name="lancamento")
 * @ORM\HasLifecycleCallbacks
 */
class Lancamento extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\Column(name="idLancamento", type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $idLancamento;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\Usuario")
     * @ORM\JoinColumn(name="idUsuario", referencedColumnName="id", nullable=false)
     * @var \Usuario\Entity\Usuario
     */
    protected $usuario;

    /**
     * @ORM\Column(name="valor", type="decimal", precision=11, scale=2, nullable=false)
     * @var float
     */
    protected $valor;

    /**
     * @ORM\Column(name="descricao", type="string", nullable=false, length=256)
     * @var string
     */
    protected $descricao;

    /**
     * @ORM\Column(name="data", type="datetime", nullable=false)
     * @var DateTime
     */
    protected $data;

    /**
     * @ORM\OneToOne(targetEntity="Financeiro\Entity\Fechamento", inversedBy="lancamento")
     * @ORM\JoinColumn(name="idFechamento", referencedColumnName="idFechamento", nullable=true)
     * @var Fechamento
     */
    protected $fechamento;

    /**
     * @return int
     */
    public function getIdLancamento()
    {
        return $this->idLancamento;
    }

    /**
     * @param int $idLancamento 
     */
    public function setIdLancamento($idLancamento)
    {
        $this->idLancamento = $idLancamento;
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

    /**
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param float $valor 
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao 
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param DateTime $data 
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}
