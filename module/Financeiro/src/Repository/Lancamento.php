<?php

namespace Financeiro\Repository;

use Application\Repository\RepositoryAbstract;
use Doctrine\Common\Collections\ArrayCollection;
use Financeiro\Repository\Lancamento as LancamentoEntity;

class Lancamento extends RepositoryAbstract
{
    /**
     * @param int $idUsuario
     * @param array $params
     * @param int|null $maxResults
     * @param int|null $offset
     * @return ArrayCollection
     */
    public function getLancamentosPorUsuario($idUsuario, $params = [], $maxResults = null, $offset = null)
    {
        if ($maxResults) {
            $this->setMaxResults($maxResults);
        }

        if ($offset) {
            $this->setOffset($offset);
        }
        $query = $this->setReturnQuery(true)->getActiveResults();
        $query->andWhere($query->expr()->eq('this.usuario', $idUsuario));

        return $query->getQuery()->getResult();
    }

    /**
     * @param int $idLancamento
     * @param int $idUsuario
     * @return LancamentoEntity
     */
    public function getLancamentoPorUsuario($idLancamento, $idUsuario)
    {
        $query = $this->setReturnQuery(true)->getActiveResult($idLancamento);
        $query->andWhere($query->expr()->eq('this.usuario', $idUsuario));

        return $query->getQuery()->getOneOrNullResult();
    }
}
