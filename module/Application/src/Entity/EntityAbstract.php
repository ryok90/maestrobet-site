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
     * @return DateTime
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
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
    public function getDataAlteracao()
    {
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
}