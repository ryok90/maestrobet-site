<?php
namespace Importacao\V1\Rpc\Banca;

use Application\Controller\ImportacaoUsuarioAbstractController;
use Usuario\Rbac\RoleProvider;

class BancaController extends ImportacaoUsuarioAbstractController
{
    public function bancaAction()
    {
        $roles = [
            RoleProvider::ROLE_BANCA,
            RoleProvider::ROLE_CLIENTE,
            RoleProvider::ROLE_USUARIO,
        ];

        return $this->insertUsuarios($roles);
    }
}
