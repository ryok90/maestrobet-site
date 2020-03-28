<?php

namespace Financeiro\Repository;

use Application\Repository\RepositoryAbstract;
use Financeiro\Entity\Extrato as ExtratoEntity;

class Extrato extends RepositoryAbstract
{
    /**
     * @param int $idUsuario
     * @return ExtratoEntity
     */
    public function getUltimoExtrato($idUsuario)
    {
        $query = $this->setReturnQuery(true)->getActiveResults();
        $query->andWhere($query->expr()->eq('this.usuario', $idUsuario));
        $query->setMaxResults(1);
        
        return $query->getQuery()->getOneOrNullResult();
    }
}