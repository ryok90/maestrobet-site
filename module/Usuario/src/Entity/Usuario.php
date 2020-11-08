<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Crypt\Password\Bcrypt;
use ZF\OAuth2\Doctrine\Entity\UserInterface;
use ZfcRbac\Identity\IdentityInterface;
use Financeiro\Entity\ContaAbstract;
use Financeiro\Entity\Extrato;

/**
 * Usuario base de toda aplicação.
 * @ORM\Entity(repositoryClass="Usuario\Repository\Usuario")
 * @ORM\Table(name="usuario")
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
     * @ORM\OneToMany(targetEntity="Financeiro\Entity\Extrato", fetch="EXTRA_LAZY", mappedBy="usuario", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $extratos;

    /**
     * Último extrato cadastrado.
     * 
     * @ORM\OneToOne(targetEntity="Financeiro\Entity\Extrato", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\JoinColumn(name="idExtrato", referencedColumnName="id", nullable=true)
     * @var Extrato
     */
    protected $extrato;

    /**
     * @ORM\Column(name="roles", type="simple_array", nullable=false)
     * @var array
     */
    protected $roles;

    /**
     * Usuário cliente.
     * 
     * @ORM\OneToOne(targetEntity="Usuario\Entity\Cliente", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\JoinColumn(name="idCliente", referencedColumnName="id", nullable=true)
     * @var Cliente
     */
    protected $cliente;

    /**
     * Usuário agente.
     * 
     * @ORM\OneToOne(targetEntity="Usuario\Entity\Agente", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\JoinColumn(name="idAgente", referencedColumnName="id", nullable=true)
     * @var Agente
     */
    protected $agente;

    /**
     * Usuário banca.
     * 
     * @ORM\OneToOne(targetEntity="Usuario\Entity\Banca", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\JoinColumn(name="idBanca", referencedColumnName="id", nullable=true)
     * @var Banca
     */
    protected $banca;

    /**
     * Usuário repasse.
     * 
     * @ORM\OneToOne(targetEntity="Usuario\Entity\Repasse", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\JoinColumn(name="idRepasse", referencedColumnName="id", nullable=true)
     * @var Repasse
     */
    protected $repasse;

    /**
     * Usuário responsável pra qual os lançamentos são direcionados.
     * 
     * @ORM\OneToOne(targetEntity="Usuario\Entity\Usuario", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\JoinColumn(name="idResponsavel", referencedColumnName="id", nullable=true)
     * @var Usuario
     */
    protected $responsavel;

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
     * Get usuário cliente.
     *
     * @return Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set usuário cliente.
     *
     * @param Cliente $cliente Usuário cliente.
     *
     * @return self
     */
    public function setCliente(Cliente $cliente)
    {
        $this->cliente = $cliente;

        return $this;
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
     * Set usuário agente.
     *
     * @param Agente $agente Usuário agente.
     *
     * @return self
     */
    public function setAgente(Agente $agente)
    {
        $this->agente = $agente;

        return $this;
    }

    /**
     * Get usuário banca.
     *
     * @return Banca
     */
    public function getBanca()
    {
        return $this->banca;
    }

    /**
     * Set usuário banca.
     *
     * @param Banca $banca Usuário banca.
     *
     * @return self
     */
    public function setBanca(Banca $banca)
    {
        $this->banca = $banca;

        return $this;
    }

    /**
     * Get usuário repasse.
     *
     * @return Repasse
     */
    public function getRepasse()
    {
        return $this->repasse;
    }

    /**
     * Set usuário repasse.
     *
     * @param Repasse $repasse Usuário repasse.
     *
     * @return self
     */
    public function setRepasse(Repasse $repasse)
    {
        $this->repasse = $repasse;

        return $this;
    }

    /**
     * Get usuário responsável pra qual os lançamentos são direcionados.
     *
     * @return Usuario
     */
    public function getResponsavel()
    {
        return $this->responsavel;
    }

    /**
     * Set usuário responsável pra qual os lançamentos são direcionados.
     *
     * @param Usuario $responsavel  Usuário responsável pra qual os lançamentos são direcionados.
     *
     * @return self
     */
    public function setResponsavel(Usuario $responsavel)
    {
        $this->responsavel = $responsavel;

        return $this;
    }

    /**
     * Get the value of desconto
     *
     * @return float
     */
    public function getDesconto()
    {
        return $this->desconto;
    }

    /**
     * Set the value of desconto
     *
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
     * Seta os tipos de acordo com os valores vindo por paramestros
     * Somente para ser usado em 'create' pois cria novos tipos
     * @param stdObject $rawData
     * @return void
     */
    public function setTipos($rawData)
    {
        empty($rawData->isAgente) ?: $this->setAgente((new Agente())->setUsuario($this));
        empty($rawData->isBanca) ?: $this->setBanca((new Banca())->setUsuario($this));
        empty($rawData->isCliente) ?: $this->setCliente((new Cliente())->setUsuario($this));
        empty($rawData->isRepasse) ?: $this->setRepasse((new Repasse())->setUsuario($this));
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
