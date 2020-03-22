<?php

namespace Usuario\Assertion;

use Usuario\Entity\Usuario;
use Zend\Permissions\Rbac\AssertionInterface;
use Zend\Permissions\Rbac\Rbac;

class AsserUserMatch implements AssertionInterface
{
    /**
     * @var Usuario
     */
    protected $originalUser;

    /**
     * @var Usuario
     */
    protected $resourceInQuestion;

    public function __construct(Usuario $usuario)
    {
        $this->originalUser = $usuario;
    }

    /**
     * @param Usuario $usuario
     * @return void
     */
    public function setResourceInQuestion(Usuario $usuario)
    {
        $this->resourceInQuestion = $usuario;
    }

    /**
     * @param Rbac $rbac
     * @return boolean
     */
    public function assert(Rbac $rbac)
    {
        if (!$this->resourceInQuestion instanceof Usuario) {

            return false;
        }

        return $this->originalUser->getId() == $this->resourceInQuestion->getId();
    }
}
