<?php

namespace Financeiro\Repository;

use Application\Repository\RepositoryAbstract;
use Financeiro\Entity\Extrato as ExtratoEntity;
use Doctrine\Common\Collections\ArrayCollection;

class Extrato extends RepositoryAbstract
{
    /**
     * @param int $idUsuario
     * @return ArrayCollection
     */
    public function getExtratosPorUsuario($idUsuario)
    {
        $query = $this->getActiveResultsQuery();
        $query->andWhere($query->expr()->eq('this.usuario', $idUsuario));

        return $query->getQuery()->getResult();
    }

    /**
     * @param int $idExtrato
     * @param int $idUsuario
     * @return ExtratoEntity|null
     */
    public function getExtratoPorUsuario($idExtrato, $idUsuario)
    {
        $query = $this->getActiveResultQuery($idExtrato);
        $query->andWhere($query->expr()->eq('this.usuario', $idUsuario));

        return $query->getQuery()->getOneOrNullResult();
    }
}
