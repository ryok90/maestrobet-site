<?php

namespace Usuario\Rbac;

/**
 * Interface para o Resource retornar ao Usuario\Rbac\Authorization
 * suas configurações de permissão
 */
interface GuardedResourceInterface
{
    /**
     * Deve retornar um array de permissões http no seguinte formato
     * return [
     *      $nomeDoMetodo => false, // Caso em que o método não pode ser acessado
     *      $nomeDoMetodo2 => true, // Caso em que o método está liberado a todas Roles
     *      $nomeDoMetodo3 => RoleProvider::ADMIN_FETCH // Caso em que o método possui a permissão ADMIN_FETCH
     * ];
     * 
     * @return array
     */
    public static function getResourceGuard();
}
