<?php

namespace Usuario;

use Application\Initializer\ServiceInitializer;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Usuario\Rbac\AuthenticationListener;
use Usuario\Rbac\Factory\AuthenticationListenerFactory;
use Usuario\Rbac\Authorization;
use Usuario\Rbac\Factory\AuthorizationFactory;
use Usuario\Service\Factory\UsuarioServiceFactory;
use Usuario\Service\UsuarioService;
use Zend\Authentication\AuthenticationService;
use ZF\MvcAuth\Authorization\AuthorizationInterface;
use ZF\MvcAuth\Factory\AuthenticationServiceFactory;

return [
    'router' => [],
    'controllers' => [
        'factories' => []
    ],
    'service_manager' => [
        'aliases' => [
            AuthorizationInterface::class => Authorization::class,
        ],
        'factories' => [
            Authorization::class => AuthorizationFactory::class,
            AuthenticationListener::class => AuthenticationListenerFactory::class,
            UsuarioService::class => UsuarioServiceFactory::class,
            AuthenticationService::class => AuthenticationServiceFactory::class
        ],
        'initializers' => [
            ServiceInitializer::class
        ]
    ],
    'view_helpers' => [
        'factories' => [],
        'aliases' => []
    ],
    'view_manager' => [],
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
