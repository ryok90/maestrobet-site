<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Entity\EntityAbstract;

/**
 * @ORM\Entity(repositoryClass="Usuario\Repository\Banca")
 * @ORM\Table(name="Usuario_Banca")
 * @ORM\HasLifecycleCallbacks
 */
class Banca extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Usuario\Entity\Usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuario", referencedColumnName="id", nullable=false)
     * @var Usuario
     */
    protected $usuario;

    /**
     * @ORM\OneToMany(targetEntity="Usuario\Entity\Usuario", fetch="EXTRA_LAZY", mappedBy="banca", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $usuarios;


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
     *
     * @return self
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of usuario
     *
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     *
     * @param Usuario $usuario
     *
     * @return self
     */
    public function setUsuario(Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'usuario' => $this->getUsuario()->toArrayMin(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function toArrayMin()
    {
        return [
            'id' => $this->getId(),
            'usuario' => $this->getUsuario()->toArrayMin(),
        ];
    }
}
