<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Abstração de Entity básica
 * Toda Entity que estender esta abstração necessita ter
 * HasLifecycleCallbacks para que a dataCriacao e dataAlteracao sejam atualizadas
 */
abstract class EntityAbstract
{
    const STATUS_DELETED = -1;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

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
}
