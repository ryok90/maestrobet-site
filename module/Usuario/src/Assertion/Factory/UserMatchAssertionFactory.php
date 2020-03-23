<?php

namespace Usuario\Assertion\Factory;

use Interop\Container\ContainerInterface;
use Usuario\Assertion\UserMatchAssertion;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserMatchAssertionFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $idFromRoute = $container->get('application')->getMvcEvent()->getRouteMatch()->getParam('usuario_id');

        return new UserMatchAssertion($idFromRoute);
    }
}
