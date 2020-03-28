<?php

namespace Financeiro\Repository;

use Application\Repository\RepositoryAbstract;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Financeiro\Repository\Lancamento as LancamentoEntity;

class Lancamento extends RepositoryAbstract
{
    /**
     * @param int $idLancamento
     * @param int $idUsuario
     * @return LancamentoEntity
     */
    public function getLancamentoPorUsuario($idLancamento, $idUsuario)
    {
        $query = $this->getActiveResultQuery($idLancamento);
        $query->andWhere($query->expr()->eq('this.usuario', $idUsuario));

        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * Recupera os lançamentos prévios ao mês corrente
     * Método utilizado na criação de um novo extrato em LancamentoResource
     * @param string $dataInicio
     * @return float
     */
    public function getSaldoLancamentosDesde($idUsuario, $dataInicio)
    {
        $query = $this->getActiveResultsQuery();
        $query->select('SUM(this.valor) as total');
        $query->andWhere($query->expr()->eq('this.usuario', $idUsuario));
        $query->andWhere($query->expr()->gte('this.dataCriacao', ':dataInicio'));
        $query->andWhere($query->expr()->lt('this.dataCriacao', ':dataFinal'));
        $query->setParameter(':dataInicio', new DateTime($dataInicio), Types::DATETIME_MUTABLE);
        $query->setParameter(':dataFinal', new DateTime('midnight first day of'), Types::DATETIME_MUTABLE);

        return $query->getQuery()->getSingleScalarResult();
    }
}
