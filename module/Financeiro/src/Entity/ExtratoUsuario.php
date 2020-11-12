<?php

namespace Financeiro\Entity;

use Usuario\Entity\Usuario;
use Doctrine\ORM\Mapping as ORM;

/**
 * Extrato refere-se ao saldo do mês anterior ao mês corrente.
 * Usado para não ser recalculado todas as transações de um usuário
 * 
 * @ORM\Entity(repositoryClass="Financeiro\Repository\ExtratoUsuario")
 * @ORM\Table(name="Financeiro_ExtratoUsuario")
 * @ORM\HasLifecycleCallbacks
 */
class ExtratoUsuario extends ExtratoAbstract
{
    /**
     * Lançamentos referentes ao mês corrente.
     * 
     * @ORM\OneToMany(targetEntity="Financeiro\Entity\Lancamento", fetch="EXTRA_LAZY", mappedBy="extratoUsuario", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $lancamentos;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\Usuario", inversedBy="extratos", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuario", referencedColumnName="id", nullable=true)
     * @var \Usuario\Entity\Usuario
     */
    protected $usuario;

    /**
     * @return ArrayCollection
     */
    public function getLancamentos()
    {
        return $this->lancamentos;
    }

    /**
     * @param ArrayCollection $lancamentos Lançamentos referentes ao mês corrente.
     */
    public function setLancamentos($lancamentos)
    {
        $this->lancamentos = $lancamentos;
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
     * @inheritdoc
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'dataExtrato' => $this->getDataExtrato(),
            'lancamentos' => $this->collectionToArray($this->getLancamentos()),
            'saldo' => $this->getSaldo(),
            'usuario' => $this->getUsuario() ? $this->getUsuario()->toArrayMin() : null
        ];
    }

    /**
     * @inheritdoc
     */
    public function toArrayMin()
    {
        return [
            'id' => $this->getId(),
            'dataExtrato' => $this->getDataExtrato(),
        ];
    }
}