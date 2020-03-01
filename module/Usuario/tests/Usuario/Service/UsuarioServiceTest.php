<?php

use Usuario\Service\UsuarioService;
use PHPUnit\Framework\TestCase;
use Usuario\Bootstrap;
use Usuario\Entity\Usuario;
require_once(__DIR__ . '/../../bootstrap.php');


class UsuarioServiceTest extends TestCase
{
    /**
     * @var UsuarioService
     */
    private $usuarioService;

    protected function getORM()
    {
        $sm = Bootstrap::getServiceManager();
        $orm = $sm->get('doctrine.entitymanager.orm_default');

        return $orm;
    }

    protected function setUp() : void
    {
        parent::setUp();

        Bootstrap::init();

        $this->usuarioService = Bootstrap::getServiceManager()->get(UsuarioService::class);
    }

    protected function tearDown() : void
    {
        $this->usuarioService = null;

        parent::tearDown();
    }

    public function test__construct()
    {
        $this->assertInstanceOf(UsuarioService::class, $this->usuarioService);
    }

    public function testInsertUsuario()
    {
        $usuario = new Usuario();
        $usuario->setNome('Teste');
        $usuario->setApelido('Teste ape');
        $usuario->setEmail('teste@teste.com');
        $usuario->setsenha('teste');

        $novoUsuario = $this->usuarioService->insertUsuario($usuario);

        $this->assertInstanceOf(Usuario::class, $novoUsuario);

        $orm = $this->getORM();
        /** @var \Doctrine\ORM\QueryBuilder $query */
        $query = $orm->createQueryBuilder()->select('usr');
        $query->from(Usuario::class, 'usr');
        $query->where($query->expr()->eq('usr.email', "'teste@teste.com'"));
        $orm->remove($query->getQuery()->getOneOrNullResult());

        $orm->flush();
        $orm->clear();
    }
}