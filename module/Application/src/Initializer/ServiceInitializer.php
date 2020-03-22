<?php

namespace Application\Initializer;

use Application\Service\ServiceAbstract;
use Exception;
use Interop\Container\ContainerInterface;
use Usuario\Entity\Usuario;
use Zend\ServiceManager\Initializer\InitializerInterface;
use ZF\ApiProblem\ApiProblem;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;

class ServiceInitializer implements InitializerInterface
{
    public function __invoke(ContainerInterface $container, $service)
    {
        if ($service instanceof ServiceAbstract) {
            try {
                $authObj = $container->get('api-identity');

                if ($authObj instanceof AuthenticatedIdentity) {

                    /** @var EntityManagerInterface $orm */
                    $orm = $container->get('doctrine.entitymanager.orm_default');
                    $oauthUserId = $container->get('api-identity')->getAuthenticationIdentity()['user_id'];
                    $userObj = $orm->find(Usuario::class, $oauthUserId);
                    $service->setAuthenticatedIdentity($userObj);
                }
            } catch (Exception $exception) {
                return new ApiProblem(500, $exception->getMessage());
            }
        }
    }
}