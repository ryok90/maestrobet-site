<?php
namespace ApiResource\V1\Rpc\ImportacaoUsuario;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\Response;
use Doctrine\ORM\EntityManager;
use Usuario\Service\UsuarioService;
use Zend\Hydrator\HydratorPluginManager;

class ImportacaoUsuarioController extends AbstractActionController
{
    /**
     * @var UsuarioService;
     */
    protected $service;
    
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var HydratorPluginManager
     */
    protected $hydratorManager;

    public function __construct($service, $entityManager, $hydratorManager)
    {
        $this->service = $service;
        $this->entityManager = $entityManager;
        $this->hydratorManager = $hydratorManager;
    }

    public function importacaoUsuarioAction()
    {
        /** @var Response $response */
        $response = $this->getResponse();

        

        return $response->setStatusCode(204);
    }
}
