<?php

namespace Usuario;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Exception;
use User\Authentication\iAuthAwareInterface;
use Usuario\Entity\Usuario;
use Usuario\Service\Factory\UsuarioServiceFactory;
use Usuario\Service\UsuarioService;
use ZF\ApiProblem\ApiProblem;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;

return [
    'router' => [
    ],
    'controllers' => [
        'factories' => [
        ]
    ],
    'service_manager' => [
        'aliases' => [
            'UsuarioService' => UsuarioService::class
        ],
        'factories' => [
            UsuarioService::class => UsuarioServiceFactory::class
        ],
        'initializers' => [
            'iAuthAwareInterface' => function($model, $serviceManager) {

                if ($model instanceof iAuthAwareInterface) {
                    try {
                        $authObj = $serviceManager->get('api-identity');

                        if ($authObj instanceof AuthenticatedIdentity) {
                            /** @var EntityManagerInterface $orm */
                            $orm = $serviceManager->get('doctrine.entitymanager.orm_default');
                            $oauthUserId = $serviceManager->get('api-identity')->getAuthenticationIdentity()['user_id'];
                            $userObj = $orm->find(Usuario::class, $oauthUserId);
                            $model->setAuthenticatedIdentity($userObj);
                        }
                    } catch (Exception $exception) {
                        return new ApiProblem(500, $exception->getMessage());
                    }
                }
            }
        ]
    ],
    'view_helpers' => [
        'factories' => [
        ],
        'aliases' => [
        ]
    ],
    'view_manager' => [
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ]
];
