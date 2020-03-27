<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Application\Entity\EntityAbstract;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;

abstract class RepositoryAbstract extends EntityRepository
{
    /**
     * Flag que determina se o método retornará
     * o resultado da query ou a própria query
     * @var bool
     */
    private $returnQuery = false;

    /**
     * @var int|null
     */
    private $maxResults = 25;

    /**
     * @var int|null
     */
    private $offset = 0;

    /**
     * @return ArrayCollection|QueryBuilder
     */
    public function getActiveResults()
    {
        $query = $this->createQueryBuilder('this');
        $expr = $query->expr();
        $query->where($expr->eq('this.status', 1));

        if ($this->maxResults > 0) {
            $query->setMaxResults($this->maxResults);
        }

        if ($this->offset > 0) {
            $query->setFirstResult($this->offset);
        }

        if ($this->returnQuery) {
            return $query;
        }

        return $query->getQuery()->getResult();
    }

    /**
     * @param int $id
     * @return EntityAbstract|QueryBuilder
     */
    public function getActiveResult($id)
    {
        $query = $this->createQueryBuilder('this');
        $expr = $query->expr();
        $query->where($expr->eq('this.status', 1));
        $query->andWhere($expr->eq('this.id', $id));

        if ($this->returnQuery) {

            return $query;
        }
        
        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * @return bool
     */
    public function getReturnQuery()
    {
        return $this->returnQuery;
    }

    /**
     * @param bool $returnQuery
     * @return self
     */
    public function setReturnQuery($returnQuery)
    {
        $this->returnQuery = $returnQuery;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }

    /**
     * @param int|null $maxResults 
     */
    public function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;
    }

    /**
     * @return int|null
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int|null $offset 
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }
}
