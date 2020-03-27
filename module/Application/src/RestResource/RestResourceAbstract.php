<?php

namespace Application\RestResource;

use ZF\Rest\AbstractResourceListener;
use Application\Service\ServiceAbstract;
use Doctrine\ORM\EntityManager;
use Application\Repository\RepositoryAbstract;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

abstract class RestResourceAbstract extends AbstractResourceListener
{
    /**
     * @var ServiceAbstract
     */
    protected $service;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var HydratorPluginManger;
     */
    private $hydratorManager;

    public function __construct($service, $entityManager, $hydratorManager = null)
    {
        $this->service = $service;
        $this->entityManager = $entityManager;
        $this->hydratorManager = $hydratorManager;
    }

    /**
     * @param string $class
     * @return RepositoryAbstract
     */
    public function getRepository($class = null)
    {
        if ($class) {

            return $this->entityManager->getRepository($class);
        }
        return $this->entityManager->getRepository($this->entityClass);
    }

    /**
     * Doctr
     * @param string $alias
     * @return DoctrineObject
     */
    public function getHydrator($alias = null)
    {
        if (empty($this->hydratorManager)) {

            return null;
        }

        if ($alias) {

            return $this->hydratorManager->get($alias);
        }

        return $this->hydratorManager->get($this->entityClass);
    }

    /**
     * @param string $param
     * @return string
     */
    public function getRouteParam($param)
    {
        return $this->getEvent()->getRouteMatch()->getParam($param);
    }
}
