<?php

namespace Importacao\V1\Rpc\Usuario;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\Response;
use Zend\Http\Request;
use Doctrine\ORM\EntityManager;
use Usuario\Service\UsuarioService;
use Zend\Hydrator\HydratorPluginManager;
use Zend\Json\Json;

class UsuarioController extends AbstractActionController
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

    public function usuarioAction()
    {
        /** @var Response $response */
        $response = $this->getResponse();

        /** @var Request $request */
        $request = $this->getRequest();
        $upload = $request->getFiles()->toArray()['usuarios'];

        $json = file_get_contents($upload['tmp_name']);
        $decoded = Json::decode($json, Json::TYPE_ARRAY);

        return $response->setStatusCode(204);
    }

    protected function hydrateUsuarios($decoded)
    {
    }
}
