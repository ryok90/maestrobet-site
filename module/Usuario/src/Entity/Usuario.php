<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\EntityAbstract;
use DateTime;
use Zend\Crypt\Password\Bcrypt;
use ZF\OAuth2\Doctrine\Entity\UserInterface;
use ZfcRbac\Identity\IdentityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Financeiro\Entity\Extrato;

/**
 * @ORM\Entity(repositoryClass="Usuario\Repository\Usuario")
 * @ORM\Table(name="usuario")
 * @ORM\HasLifecycleCallbacks
 */
class Usuario extends EntityAbstract implements UserInterface, IdentityInterface
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
     * Propriedades necessárias para autenticação via Doctrine OAuth2
     */
    protected $client;
    protected $accessToken;
    protected $authorizationCode;
    protected $refreshToken;

    public function __construct()
    {

    }

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
     * @return ArrayCollection
     */
    public function getExtratos()
    {
        return $this->extratos;
    }

    /**
     * @param ArrayCollection $extratos
     */
    public function setExtratos($extratos)
    {
        $this->extratos = $extratos;
    }

    /**
     * @return Extrato
     */
    public function getExtrato()
    {
        return $this->extrato;
    }

    /**
     * @param Extrato $extrato Último extrato cadastrado.
     */
    public function setExtrato($extrato)
    {
        $this->extrato = $extrato;
    }

    /**
     * @return float
     */
    public function saldoTotalAtual()
    {
        if ($this->getExtrato() instanceof Extrato) {

            return $this->getExtrato()->saldoTotalAtual();
        }
        
        return 0.0;
    }

    /**
     * Gera um novo extrato baseado no extrato anterior
     * @param Usuario $usuarioCriador
     * @return Extrato
     */
    public function gerarNovoExtrato($usuarioCriador)
    {
        $novoExtrato = new Extrato();
        $novoExtrato->setSaldo($this->saldoTotalAtual());
        $novoExtrato->setUsuario($this);
        $novoExtrato->setUsuarioCriador($usuarioCriador);
        $novoExtrato->setDataExtrato(new DateTime('first day of'));
        $this->setExtrato($novoExtrato);

        return $this->getExtrato();
    }

    public function toArrayMin()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'apelido' => $this->getApelido(),
            'saldo' => $this->saldoTotalAtual()
        ];
    }

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
