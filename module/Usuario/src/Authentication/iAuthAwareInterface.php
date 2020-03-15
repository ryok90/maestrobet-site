<?php

namespace Usuario\Authentication;

use Usuario\Entity\Usuario;

interface iAuthAwareInterface
{
    /**
     * @param AuthenticationServiceInterface $authService
     */
    public function setAuthenticatedIdentity(Usuario $usuario);

    /**
     * @return User
     * @throws InvalidIdentityException
     */
    public function getAuthenticatedIdentity();
}