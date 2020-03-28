<?php

namespace Usuario\HydratorFilter;

use Zend\Hydrator\Filter\FilterInterface;

/**
 * Filtro usado na resposta do hal da Api
 */
class UsuarioFilter implements FilterInterface
{
    /**
     * @param string $field
     * @return bool
     */
    public function filter($field)
    {
        $allowedFields = [
            'id',
            'nome',
            'email',
            'roles',
            'status',
            'extrato',
            'usuarioCriador',
        ];

        return in_array($field, $allowedFields);
    }
}