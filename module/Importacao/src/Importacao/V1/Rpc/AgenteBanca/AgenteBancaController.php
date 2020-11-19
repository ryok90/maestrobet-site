<?php

namespace Importacao\V1\Rpc\AgenteBanca;

use Application\Controller\ImportacaoUsuarioAbstractController;
use Usuario\Rbac\RoleProvider;
use Zend\Json\Json;
use Usuario\Service\UsuarioService;

class AgenteBancaController extends ImportacaoUsuarioAbstractController
{
    public function agenteBancaAction()
    {
        $roles = [
            RoleProvider::ROLE_AGENTE,
            RoleProvider::ROLE_BANCA,
            RoleProvider::ROLE_CLIENTE,
            RoleProvider::ROLE_USUARIO,
        ];

        return $this->insertUsuarios($roles);
    }
}
