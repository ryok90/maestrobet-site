<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Usuario\Entity\Usuario;

/**
 * Abstração de Entity básica.
 * Toda Entity que estender esta abstração necessita ter
 * HasLifecycleCallbacks para que a dataCriacao e dataAlteracao
 * sejam atualizadas automaticamente.
 */
abstract class EntityAbstract
{
    const STATUS_DELETED = -1;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * Usuario criador/autor do registro
     * 
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\Usuario", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="idUsuarioCriador", referencedColumnName="id", nullable=true)
     * @var Usuario
     */
    protected $usuarioCriador;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var DateTime
     */
    protected $dataCriacao;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $dataAlteracao;

    /**
     * @ORM\Column(type="smallint")
     * @var string
     */
    protected $status = self::STATUS_ACTIVE;

    /**
     * Retorno para a API
     * Normalmente utilizado nos métodos fetch
     * @return array
     */
    abstract public function toArray();

    /**
     * Retorno mínimo para a API para evitar referência circular
     * Normalmente retorno somente a propriedades vitais
     * @return array
     */
    abstract public function toArrayMin();

    /**
     * @return Usuario
     */
    public function getUsuarioCriador()
    {
        return $this->usuarioCriador;
    }

    /**
     * @param Usuario $usuarioCriador
     */
    public function setUsuarioCriador($usuarioCriador)
    {
        $this->usuarioCriador = $usuarioCriador;
    }
    /**
     * @return DateTime
     */
    public function getDataCriacao($format = 'Y-m-d H:i')
    {
        return $this->dataCriacao->format($format);
    }

    /**
     * @param DateTime $dataCriacao 
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;
    }

    /**
     * @return DateTime
     */
    public function getDataAlteracao($format = 'Y-m-d H:i')
    {
        if ($this->dataAlteracao instanceof DateTime) {

            return $this->dataAlteracao->format($format = 'Y-m-d H:i');
        }

        return $this->dataAlteracao;
    }

    /**
     * @param DateTime $dataAlteracao 
     */
    public function setDataAlteracao($dataAlteracao)
    {
        $this->dataAlteracao = $dataAlteracao;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status 
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function logicalDelete()
    {
        $this->setStatus(-1);
    }

    /**
     * @ORM\PrePersist
     */
    public function defineDataCriacao()
    {
        $this->setDataCriacao(new DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function defineDataAlteracao()
    {
        $this->setDataAlteracao(new DateTime());
    }

    public function collectionToArray($collection)
    {
        $array = [];

        foreach ($collection as $item) {
            $array[] = $item->toArrayMin();
        }
        
        return $array;
    }
}
