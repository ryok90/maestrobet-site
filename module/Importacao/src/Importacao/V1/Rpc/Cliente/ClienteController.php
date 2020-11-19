<?php
namespace Importacao\V1\Rpc\Cliente;

use Application\Controller\ImportacaoUsuarioAbstractController;
use Usuario\Rbac\RoleProvider;

class ClienteController extends ImportacaoUsuarioAbstractController
{
    public function clienteAction()
    {
        $roles = [
            RoleProvider::ROLE_CLIENTE,
            RoleProvider::ROLE_USUARIO,
        ];

        return $this->insertUsuarios($roles);
    }
}
