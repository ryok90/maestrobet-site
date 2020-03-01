<?php

namespace Identidade\V1\Rest\Usuario;

use Usuario\Service\UsuarioService;

class UsuarioResourceFactory
{
    public function __invoke($services)
    {
        $usuarioService = $services->get(UsuarioService::class);

        return new UsuarioResource($usuarioService);
    }
}
