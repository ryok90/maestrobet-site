<?php

namespace Financeiro;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Financeiro\Entity\Lancamento;
use Financeiro\Service\Factory\LancamentoServiceFactory;
use Financeiro\Service\LancamentoService;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [],
    'controllers' => [
        'factories' => []
    ],
    'service_manager' => [
        'factories' => [
            LancamentoService::class => LancamentoServiceFactory::class,
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
    ],
];
