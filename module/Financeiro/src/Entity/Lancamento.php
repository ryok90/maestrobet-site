<?php

namespace Financeiro\Entity;

use Usuario\Entity\Usuario;
use Application\Entity\EntityAbstract;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Financeiro\Entity\Fechamento;
use Financeiro\Repository\Extrato;
/**
 * @ORM\Entity(repositoryClass="Financeiro\Repository\Lancamento")
 * @ORM\Table(name="lancamento")
 * @ORM\HasLifecycleCallbacks
 */
class Lancamento extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Financeiro\Entity\Extrato", inversedBy="lancamentos", cascade={"persist"})
     * @ORM\JoinColumn(name="idExtrato", referencedColumnName="id", nullable=false)
     * @var Extrato
     */
    protected $extrato;

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
     * @ORM\Column(name="dataLancamento", type="date", nullable=false)
     * @var DateTime
     */
    protected $dataLancamento;

    /**
     * @ORM\OneToOne(targetEntity="Financeiro\Entity\Fechamento", inversedBy="lancamento", cascade={"persist"})
     * @ORM\JoinColumn(name="idFechamento", referencedColumnName="id", nullable=true)
     * @var Fechamento
     */
    protected $fechamento;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\Usuario")
     * @ORM\JoinColumn(name="idUsuario", referencedColumnName="id", nullable=false)
     * @var Usuario
     */
    protected $usuario;

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
     * @return float
     */
    public function getValor()
    {
        return (float) $this->valor;
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
    public function getDataLancamento($format = 'Y-m-d')
    {
        if ($this->dataLancamento instanceof DateTime) {

            return $this->dataLancamento->format($format);
        }

        return $this->dataLancamento;
    }

    /**
     * @param DateTime $dataLancamento 
     */
    public function setDataLancamento($dataLancamento)
    {
        $this->dataLancamento = $dataLancamento;
    }

    /**
     * @return Extrato
     */
    public function getExtrato()
    {
        return $this->extrato;
    }

    /**
     * @param Extrato $extrato 
     */
    public function setExtrato($extrato)
    {
        $this->extrato = $extrato;
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
     * @return Fechamento
     */
    public function getFechamento()
    {
        return $this->fechamento;
    }

    /**
     * @param Fechamento $fechamento 
     */
    public function setFechamento($fechamento)
    {
        $this->fechamento = $fechamento;
    }

    /**
     * @inheritDoc
     */
    public function toArrayMin()
    {
        return [
            'id' => $this->getId(),
            'valor' => $this->getValor(),
            'descricao' => $this->getDescricao(),
            'dataLancamento' => $this->getDataLancamento(),
            'dataCriacao' => $this->getDataCriacao(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'valor' => $this->getValor(),
            'descricao' => $this->getDescricao(),
            'dataLancamento' => $this->getDataLancamento(),
            'dataCriacao' => $this->getDataCriacao(),
            'usuario' => $this->getUsuario() ? $this->getUsuario()->toArrayMin() : null,
            'extrato' => $this->getExtrato() ? $this->getExtrato()->toArrayMin() : null,
            'fechamento' => $this->getFechamento() ? $this->getFechamento()->toArrayMin() : null,
        ];
    }
}
