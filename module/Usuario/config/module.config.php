<?php

namespace Usuario;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Usuario\Service\Factory\UsuarioServiceFactory;
use Usuario\Service\UsuarioService;

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
