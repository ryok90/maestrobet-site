<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class EntityAbstract
{
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
    protected $status = 1;

    /**
     * Get the value of dataCriacao
     *
     * @return DateTime
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    /**
     * Set the value of dataCriacao
     *
     * @param DateTime $dataCriacao 
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;
    }

    /**
     * Get the value of dataAlteracao
     *
     * @return DateTime
     */
    public function getDataAlteracao()
    {
        return $this->dataAlteracao;
    }

    /**
     * Set the value of dataAlteracao
     *
     * @param DateTime $dataAlteracao 
     */
    public function setDataAlteracao($dataAlteracao)
    {
        $this->dataAlteracao = $dataAlteracao;
    }

    /**
     * Get the value of status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param string $status 
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}