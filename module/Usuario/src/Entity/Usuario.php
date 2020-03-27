<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\EntityAbstract;
use Zend\Crypt\Password\Bcrypt;
use ZF\OAuth2\Doctrine\Entity\UserInterface;
use ZfcRbac\Identity\IdentityInterface;

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
     * @ORM\OneToMany(targetEntity="Financeiro\Entity\Lancamento", fetch="EXTRA_LAZY", mappedBy="usuario", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $lancamentos;

    /**
     * Extrato com total até o mês anterior ao mês atual
     * Incluído mais um extrato toda primeira vez do mês em que é requisitado o saldo
     * 
     * @ORM\OneToMany(targetEntity="Financeiro\Entity\Extrato", fetch="EXTRA_LAZY", mappedBy="usuario", cascade={"persist"})
     * @var Extrato
     */
    protected $extratos;

    /**
     * @ORM\Column(name="roles", type="array", nullable=false)
     * @var array
     */
    protected $roles;

    /**
     * Propriedade não salva no banco
     * Existe para ser repassada pela Api como total do saldo
     * @var float
     */
    protected $saldo;

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
    public function getLancamentos()
    {
        return $this->lancamentos;
    }

    /**
     * @param ArrayCollection $lancamentos 
     */
    public function setLancamentos($lancamentos)
    {
        $this->lancamentos = $lancamentos;
    }

    /**
     * @param stdClass $data
     * @return void
     */
    public function patch($data)
    {
        empty($data->senha) ?: $this->setSenha($data->senha);
        empty($data->nome) ?: $this->setNome($data->nome);
        empty($data->email) ?: $this->setNome($data->email);
        empty($data->apelido) ?: $this->setNome($data->apelido);
        empty($data->roles) ?: $this->setRoles($data->roles);
    }

    /**
     * @return Extrato
     */
    public function getExtratos()
    {
        return $this->extratos;
    }

    /**
     * @param Extrato $extratos Valor atualizado toda primeira vez do mês em que é requisitado o saldo
     */
    public function setExtratos($extratos)
    {
        $this->extratos = $extratos;
    }
}
