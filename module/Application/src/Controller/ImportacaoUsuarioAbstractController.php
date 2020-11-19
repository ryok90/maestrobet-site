<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Usuario\Service\UsuarioService;
use Zend\Hydrator\HydratorPluginManager;
use Doctrine\ORM\EntityManager;
use Usuario\Entity\Usuario;
use Application\Repository\RepositoryAbstract;
use Usuario\Repository\Usuario as UsuarioRepository;
use Zend\Json\Json;

class ImportacaoUsuarioAbstractController extends AbstractActionController
{
    /**
     * @var UsuarioService;
     */
    private $service;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var HydratorPluginManager
     */
    private $hydratorManager;

    public function __construct($service, $entityManager, $hydratorManager)
    {
        $this->service = $service;
        $this->entityManager = $entityManager;
        $this->hydratorManager = $hydratorManager;
    }

    /**
     * @return UsuarioService;
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param UsuarioService $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return HydratorPluginManager
     */
    public function getHydratorManager()
    {
        return $this->hydratorManager;
    }

    /**
     * @param HydratorPluginManager $hydratorManager
     */
    public function setHydratorManager($hydratorManager)
    {
        $this->hydratorManager = $hydratorManager;
    }

    protected function insertUsuarios($roles)
    {

        /** @var Request $request */
        $request = $this->getRequest();
        $upload = $request->getFiles()->toArray()['usuarios'];

        $json = file_get_contents($upload['tmp_name']);
        $decoded = Json::decode($json, Json::TYPE_ARRAY);
        $usuarios = $this->parseUsuarios($decoded, $roles);

        /** @var UsuarioService $service */
        $service = $this->getService();
        $service->insertBatch($usuarios);

        /** @var Response $response */
        $response = $this->getResponse();
        $response->setStatusCode(204);
        return;
    }

    /**
     * Converte usuarios em array (vindo de json)
     * para array de objetos Usuario
     * @param array $usuariosJson
     * @param array $roles
     * @return array
     */
    protected function parseUsuarios($usuariosJson, $roles)
    {
        $usuarios = [];

        foreach ($usuariosJson as $usuarioArray) {
            $nome = $usuarioArray['nome'];
            $instance = new Usuario();
            $instance->setNome($nome);
            $instance->setApelido($nome);
            $instance->setEmail($this->generateEmail($nome));
            $instance->setSenha('mudar123');
            $instance->setRoles($roles);

            $usuarios[] = $instance;
        }

        return $usuarios;
    }

    /**
     * @param string $classname
     * @return UsuarioRepository|RepositoryAbstract
     */
    protected function getRepository($classname = null)
    {
        if ($classname) {
            return $this->getEntityManager()->getRepository($classname);
        }

        return $this->getEntityManager()->getRepository(Usuario::class);
    }

    /**
     * Cria e-mail fake do dominio da maestro a partir do nome
     * @param string $nome
     * @return string
     */
    protected function generateEmail($nome)
    {
        $email = strtolower($nome);
        $email = explode(' ', $email);
        $email = implode('.', $email);

        return $email . '@maestrobet.com.br';
    }

}