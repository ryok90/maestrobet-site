<?php

namespace Financeiro\Entity;

use Usuario\Entity\Usuario;
use Application\Entity\EntityAbstract;
use Doctrine\ORM\Mapping as ORM;

abstract class LancamentoAbstract extends EntityAbstract
{
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
     * @var \DateTime
     */
    protected $data;

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
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param \DateTime $data 
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}