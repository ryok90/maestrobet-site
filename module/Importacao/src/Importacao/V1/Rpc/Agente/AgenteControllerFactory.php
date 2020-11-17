<?php
namespace Importacao\V1\Rpc\Agente;

class AgenteControllerFactory
{
    public function __invoke($controllers)
    {
        return new AgenteController();
    }
}
