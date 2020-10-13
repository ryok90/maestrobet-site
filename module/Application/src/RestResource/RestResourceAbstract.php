<?php

namespace Application\RestResource;

use ZF\Rest\AbstractResourceListener;
use Application\Service\ServiceAbstract;
use Doctrine\ORM\EntityManager;
use Application\Repository\RepositoryAbstract;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Usuario\Entity\Usuario;

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

    /**
     * Usuario autenticado
     * @var Usuario
     */
    protected $identity;

    public function __construct($service, $entityManager, $identity, $hydratorManager = null)
    {
        $this->service = $service;
        $this->entityManager = $entityManager;
        $this->identity = $identity;
        $this->hydratorManager = $hydratorManager;
    }

    /**
     * @param string $class
     * @return RepositoryAbstract
     */
    protected function getRepository($class = null)
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
    protected function getHydrator($alias = null)
    {
        if (empty($this->hydratorManager)) {

            return null;
        }

        return $this->hydratorManager->get(DoctrineObject::class);
    }

    /**
     * object é o objeto da classe que deseja estar hidratado
     */
    protected function getHydratedObject($object)
    {
        $data = $this->getInputFilter()->getValues();
        $hydrator = $this->getHydrator();

        return $hydrator->hydrate($data, $object);
    }

    /**
     * @param string $param
     * @return string
     */
    protected function getRouteParam($param)
    {
        return $this->getEvent()->getRouteMatch()->getParam($param);
    }

    /**
     * @return Usuario
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param Usuario $identity Usuario autenticado
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }

    protected function collectionToArray($collection)
    {
        $array = [];

        foreach ($collection as $item) {
            $array[] = $item->toArrayMin();
        }

        return $array;
    }


}
