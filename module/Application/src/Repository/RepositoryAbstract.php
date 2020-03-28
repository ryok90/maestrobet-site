<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Application\Entity\EntityAbstract;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;

abstract class RepositoryAbstract extends EntityRepository
{
    /**
     * @var int|null
     */
    private $maxResults = 25;

    /**
     * @var int|null
     */
    private $offset = 0;

    protected function getActiveBaseQuery()
    {
        $query = $this->createQueryBuilder('this');
        $query->where($query->expr()->eq('this.status', 1));

        return $query;
    }

    protected function getActiveResultsQuery()
    {
        $query = $this->getActiveBaseQuery();

        if ($this->maxResults > 0) {
            $query->setMaxResults($this->maxResults);
        }

        if ($this->offset > 0) {
            $query->setFirstResult($this->offset);
        }

        return $query;
    }

    protected function getActiveResultQuery($id)
    {
        $query = $this->getActiveBaseQuery();
        $query->andWhere($query->expr()->eq('this.id', $id));

        return $query;
    }

    /**
     * @return ArrayCollection|QueryBuilder
     */
    public function getActiveResults()
    {
        $query = $this->getActiveResultsQuery();

        return $query->getQuery()->getResult();
    }

    /**
     * @param int $id
     * @return EntityAbstract|QueryBuilder
     */
    public function getActiveResult($id)
    {
        $query = $this->getActiveResultQuery($id);

        return $query->getQuery()->getOneOrNullResult();
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
     * @return self
     */
    public function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;

        return $this;
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
     * @return self
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }
}
