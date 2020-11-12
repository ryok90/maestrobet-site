<?php

namespace Financeiro\Entity;

use Usuario\Entity\Usuario;
use Application\Entity\EntityAbstract;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="Financeiro\Repository\Lancamento")
 * @ORM\Table(name="Financeiro_Lancamento")
 * @ORM\HasLifecycleCallbacks
 */
class Lancamento extends EntityAbstract
{
    /**
     * Tipos de Lançamento
     */
    const AGENTE = 'agente';
    const BANCA = 'banca';
    const CLIENTE = 'cliente';
    const REPASSE = 'repasse';
    const USUARIO = 'usuario';
    const PAGAMENTO = 'pagamento';
    const RECEBIMENTO = 'recebimento';
    const FECHAMENTO = 'fechamento';
    const TRANSFERENCIA = 'transferencia';
    const APORTE = 'aporte';

    /**
     * @var array
     */
    const TIPOS_LANCAMENTO = [
        self::AGENTE,
        self::BANCA,
        self::CLIENTE,
        self::REPASSE,
        self::USUARIO,
        self::PAGAMENTO,
        self::RECEBIMENTO,
        self::TRANSFERENCIA,
        self::APORTE,
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Financeiro\Entity\ExtratoUsuario", inversedBy="lancamentos", cascade={"persist"})
     * @ORM\JoinColumn(name="idExtratoUsuario", referencedColumnName="id", nullable=true)
     * @var ExtratoUsuario
     */
    protected $extratoUsuario;

    /**
     * @ORM\ManyToOne(targetEntity="Financeiro\Entity\ExtratoBanco", inversedBy="lancamentos", cascade={"persist"})
     * @ORM\JoinColumn(name="idExtratoBanco", referencedColumnName="id", nullable=true)
     * @var ExtratoUsuario
     */
    protected $extratoBanco;

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
     * @ORM\Column(name="tipo", type="string", nullable=false, length=32)
     * @var string
     */
    protected $tipo = self::USUARIO;

    /**
     * @ORM\ManyToOne(targetEntity="Financeiro\Entity\Banco")
     * @ORM\JoinColumn(name="idBanco", referencedColumnName="id", nullable=true)
     * @var Banco
     */
    protected $banco;

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
     * @return ExtratoUsuario
     */
    public function getExtratoUsuario()
    {
        return $this->extratoUsuario;
    }

    /**
     * @param ExtratoUsuario $extrato 
     */
    public function setExtratoUsuario($extrato)
    {
        $this->extratoUsuario = $extrato;
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
     * Get the value of tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @param string $tipo
     *
     * @return self
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * @return Banco
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * @param Banco $banco
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;
    }

    /**
     * @return Extrato
     */
    public function getExtratoBanco()
    {
        return $this->extratoBanco;
    }

    /**
     * @param Extrato $extratoBanco
     *
     * @return self
     */
    public function setExtratoBanco($extratoBanco)
    {
        $this->extratoBanco = $extratoBanco;

        return $this;
    }

    /**
     * Atualiza os Extratos atuais de banco e de usuario
     * @return void
     */
    public function updateExtratos()
    {
        $usuario = $this->getUsuario();

        if ($usuario instanceof Usuario) {
            $this->setExtratoUsuario($usuario->getExtratoAtual());
        }
        $banco = $this->getBanco();

        if ($banco instanceof Banco) {
            $this->setExtratoBanco($banco->getExtratoAtual());
        }
    }

    public function updateResponsavel()
    {
        $responsavel = $this->getUsuario()->getResponsavel();

        if ($responsavel instanceof Usuario) {
            $this->setUsuario($responsavel);
        }
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
            'extratoUsuario' => $this->getExtratoUsuario() ? $this->getExtratoUsuario()->toArrayMin() : null,
            'banco' => $this->getBanco() ? $this->getBanco()->toArrayMin() : null,
            'extratoBanco' => $this->getExtratoBanco() ? $this->getExtratoBanco()->toArrayMin() : null,
            'fechamento' => $this->getFechamento() ? $this->getFechamento()->toArrayMin() : null,
        ];
    }
}
