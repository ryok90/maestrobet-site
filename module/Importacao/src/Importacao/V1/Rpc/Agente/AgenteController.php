<?php
namespace Importacao\V1\Rpc\Agente;

use Application\Controller\ImportacaoUsuarioAbstractController;
use Usuario\Rbac\RoleProvider;

class AgenteController extends ImportacaoUsuarioAbstractController
{
    public function agenteAction()
    {
        $roles = [
            RoleProvider::ROLE_AGENTE,
            RoleProvider::ROLE_CLIENTE,
            RoleProvider::ROLE_USUARIO,
        ];

        return $this->insertUsuarios($roles);
    }
}
