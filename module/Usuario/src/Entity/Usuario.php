<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\EntityAbstract;
use Zend\Crypt\Password\Bcrypt;
use ZF\OAuth2\Doctrine\Entity\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario extends EntityAbstract implements UserInterface
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
     */
    protected $senha;

    /**
     * @ORM\OneToMany(targetEntity="Financeiro\Entity\Credito", mappedBy="usuario", fetch="EXTRA_LAZY", cascade="persist")
     * @var ArrayCollection
     */
    protected $creditos;

    /**
     * @ORM\OneToMany(targetEntity="Financeiro\Entity\Debito", mappedBy="usuario", fetch="EXTRA_LAZY", cascade="persist")
     * @var ArrayCollection
     */
    protected $debitos;

    /**
     * Propriedades necessárias para autenticação via Doctrine OAuth2
     */
    protected $client;
    protected $accessToken;
    protected $authorizationCode;
    protected $refreshToken;

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
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return mixed
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @return mixed
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha 
     */
    public function setSenha($senha)
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(10);

        $this->senha = $bcrypt->create($senha);
    }

    /**
     * Método utilizado pelo doctrine oauth2
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * @return ArrayCollection
     */
    public function getCreditos()
    {
        return $this->creditos;
    }

    /**
     * @param ArrayCollection $creditos 
     */
    public function setCreditos($creditos)
    {
        $this->creditos = $creditos;
    }

    /**
     * @return ArrayCollection
     */
    public function getDebitos()
    {
        return $this->debitos;
    }

    /**
     * @param ArrayCollection $debitos 
     */
    public function setDebitos($debitos)
    {
        $this->debitos = $debitos;
    }
}
