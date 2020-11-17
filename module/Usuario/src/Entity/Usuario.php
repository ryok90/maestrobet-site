<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Crypt\Password\Bcrypt;
use ZF\OAuth2\Doctrine\Entity\UserInterface;
use ZfcRbac\Identity\IdentityInterface;
use Financeiro\Entity\ContaAbstract;
use Financeiro\Entity\ExtratoUsuario;

/**
 * Usuario base de toda aplicação.
 * @ORM\Entity(repositoryClass="Usuario\Repository\Usuario")
 * @ORM\Table(name="Usuario_Usuario")
 * @ORM\HasLifecycleCallbacks
 */
class Usuario extends ContaAbstract implements UserInterface, IdentityInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(name="nome", type="string", nullable=false, length=64)
     * @var string
     */
    protected $nome;

    /**
     * @ORM\Column(name="apelido", type="string", nullable=false, length=64, unique=true)
     * @var string
     */
    protected $apelido;

    /**
     * @ORM\Column(name="email", type="string", nullable=false, length=64, unique=true)
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(name="senha", type="string", nullable=false, length=256)
     * @var string
     */
    protected $senha;

    /**
     * Todos os extratos mensais.
     * Extratos possuem saldo que refere à soma dos lançamentos até seu mês corrente.
     * 
     * @ORM\OneToMany(targetEntity="Financeiro\Entity\ExtratoUsuario", fetch="EXTRA_LAZY", mappedBy="usuario", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $extratos;

    /**
     * Último extrato cadastrado.
     * 
     * @ORM\OneToOne(targetEntity="Financeiro\Entity\ExtratoUsuario", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\JoinColumn(name="idExtrato", referencedColumnName="id", nullable=true)
     * @var ExtratoUsuario
     */
    protected $extrato;

    /**
     * @ORM\Column(name="roles", type="simple_array", nullable=false)
     * @var array
     */
    protected $roles;

    /**
     * Agente responsável pelo usuário
     * 
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\Agente", inversedBy="usuarios", cascade={"persist"})
     * @ORM\JoinColumn(name="idAgente", referencedColumnName="id", nullable=true)
     * @var Agente
     */
    protected $agente;

    /**
     * @ORM\Column(name="commissaoAgentePerca", type="decimal", precision=2, scale=2, nullable=true)
     * @var float
     */
    protected $commissaoAgentePerca;

    /**
     * @ORM\Column(name="commissaoAgenteGanho", type="decimal", precision=2, scale=2, nullable=true)
     * @var float
     */
    protected $commissaoAgenteGanho;

    /**
     * Banca 1 com participação do usuário
     * 
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\Banca", inversedBy="usuarios", cascade={"persist"})})
     * @ORM\JoinColumn(name="idBanca1", referencedColumnName="id", nullable=true)
     * @var Banca
     */
    protected $banca1;

    /**
     * @ORM\Column(name="participacaoBanca1", type="decimal", precision=2, scale=2, nullable=true)
     * @var float
     */
    protected $participacaoBanca1;

    /**
     * Banca 2 com participação do usuário
     * 
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\Banca", inversedBy="usuarios", cascade={"persist"})})
     * @ORM\JoinColumn(name="idBanca2", referencedColumnName="id", nullable=true)
     * @var Banca
     */
    protected $banca2;

    /**
     * @ORM\Column(name="participacaoBanca2", type="decimal", precision=2, scale=2, nullable=true)
     * @var float
     */
    protected $participacaoBanca2;

    /**
     * Usuário responsável pra qual os lançamentos são direcionados.
     * 
     * @ORM\OneToOne(targetEntity="Usuario\Entity\Usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="idResponsavel", referencedColumnName="id", nullable=true)
     * @var Usuario
     */
    protected $responsavel;

    /**
     * Usuário como Agente
     * 
     * @ORM\OneToOne(targetEntity="Usuario\Entity\Agente", mappedBy="usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuarioAgente", referencedColumnName="id", nullable=true)
     * @var Usuario
     */
    protected $usuarioAgente;

    /**
     * Usuário como Banca
     * 
     * @ORM\OneToOne(targetEntity="Usuario\Entity\Agente", mappedBy="usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuarioBanca", referencedColumnName="id", nullable=true)
     * @var Usuario
     */
    protected $usuarioBanca;

    /**
     * @ORM\Column(name="desconto", type="decimal", precision=2, scale=2, nullable=true)
     * @var float
     */
    protected $desconto = 0;

    /**
     * Propriedades necessárias para autenticação via Doctrine OAuth2
     */
    protected $client;
    protected $accessToken;
    protected $authorizationCode;
    protected $refreshToken;

    /**
     * Métodos utilizados pelo doctrine oauth2
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param mixed $accessToken 
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return mixed
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @param mixed $authorizationCode 
     */
    public function setAuthorizationCode($authorizationCode)
    {
        $this->authorizationCode = $authorizationCode;
    }

    /**
     * @return mixed
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param mixed $refreshToken 
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * ----------- End Doctrine Auth
     */

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
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome 
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getApelido()
    {
        return $this->apelido;
    }

    /**
     * @param string $apelido 
     */
    public function setApelido($apelido)
    {
        $this->apelido = $apelido;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email 
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param string $senha 
     */
    public function setSenha($senha)
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(10);

        if (is_null($senha)) {
            $senha = 'mudar123';
        }

        $this->senha = $bcrypt->create($senha);
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles 
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param string|mixed $role
     * @return void
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
    }

    /**
     * Get usuário agente.
     *
     * @return Agente
     */
    public function getAgente()
    {
        return $this->agente;
    }

    /**
     * @param Agente $agente
     * 
     * @return self
     */
    public function setAgente($agente)
    {
        $this->agente = $agente;

        return $this;
    }

    /**
     * @return Banca
     */
    public function getBanca()
    {
        return $this->banca;
    }

    /**
     * @param Banca $banca
     *
     * @return self
     */
    public function setBanca($banca)
    {
        $this->banca = $banca;

        return $this;
    }

    /**
     * @return Banca
     */
    public function getBanca2()
    {
        return $this->banca2;
    }

    /**
     * @param Banca $banca2
     *
     * @return self
     */
    public function setBanca2($banca2)
    {
        $this->banca2 = $banca2;

        return $this;
    }

    /**
     * @return float
     */
    public function getCommissaoAgentePerca()
    {
        return $this->commissaoAgentePerca;
    }

    /**
     * @param float $commissaoAgentePerca
     */
    public function setCommissaoAgentePerca($commissaoAgentePerca)
    {
        $this->commissaoAgentePerca = $commissaoAgentePerca;
    }

    /**
     * @return float
     */
    public function getCommissaoAgenteGanho()
    {
        return $this->commissaoAgenteGanho;
    }

    /**
     * @param float $commissaoAgenteGanho
     */
    public function setCommissaoAgenteGanho($commissaoAgenteGanho)
    {
        $this->commissaoAgenteGanho = $commissaoAgenteGanho;
    }

    /**
     * @return float
     */
    public function getParticipacaoBanca1()
    {
        return $this->participacaoBanca1;
    }

    /**
     * @param float $participacaoBanca1
     */
    public function setParticipacaoBanca1($participacaoBanca1)
    {
        $this->participacaoBanca1 = $participacaoBanca1;
    }

    /**
     * @return float
     */
    public function getParticipacaoBanca2()
    {
        return $this->participacaoBanca2;
    }

    /**
     * @param float $participacaoBanca2
     */
    public function setParticipacaoBanca2($participacaoBanca2)
    {
        $this->participacaoBanca2 = $participacaoBanca2;
    }

    /**
     * @return Usuario
     */
    public function getResponsavel()
    {
        return $this->responsavel;
    }

    /**
     * @param Usuario $responsavel
     *
     * @return self
     */
    public function setResponsavel($responsavel)
    {
        $this->responsavel = $responsavel;

        return $this;
    }

    /**
     * @return float
     */
    public function getDesconto()
    {
        return $this->desconto;
    }

    /**
     * @param float $desconto
     *
     * @return self
     */
    public function setDesconto(float $desconto)
    {
        $this->desconto = $desconto;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArrayMin()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'apelido' => $this->getApelido(),
            'saldo' => $this->saldoTotalAtual()
        ];
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'apelido' => $this->getApelido(),
            'email' => $this->getEmail(),
            'roles' => $this->getRoles(),
            'extrato' => $this->getExtrato() ? $this->getExtrato()->toArrayMin() : null,
            'saldo' => $this->saldoTotalAtual()
        ];
    }
}
