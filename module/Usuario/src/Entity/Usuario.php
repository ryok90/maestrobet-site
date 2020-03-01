<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\EntityAbstract;
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

    protected $client;

    protected $accessToken;
    
    protected $authorizationCode;

    protected $refreshToken;

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param int $id 
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the value of nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     *
     * @param string $nome 
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * Get the value of apelido
     *
     * @return string
     */
    public function getApelido()
    {
        return $this->apelido;
    }

    /**
     * Set the value of apelido
     *
     * @param string $apelido 
     */
    public function setApelido($apelido)
    {
        $this->apelido = $apelido;
    }

    /**
     * Get the value of email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param string $email 
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get the value of client
     *
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Get the value of accessToken
     *
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Get the value of authorizationCode
     *
     * @return mixed
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * Get the value of refreshToken
     *
     * @return mixed
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * Get the value of senha
     *
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Set the value of senha
     *
     * @param mixed $senha 
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }
}
