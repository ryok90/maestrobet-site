<?php
return [
    'doctrine' => [
        'migrations_configuration' => [
            'orm_default' => [
                'directory' => 'data/Migrations',
                'name' => 'Doctrine Database Migrations',
                'namespace' => 'Migrations',
                'table' => 'migrations',
            ],
        ],
    ],
    'zf-oauth2' => [
        'storage' => 'oauth2.doctrineadapter.default',
    ],
    'zf-mvc-auth' => [
        'authentication' => [
            'adapters' => [
                'oauth2_doctrine' => [
                    'adapter' => 'ZF\\MvcAuth\\Authentication\\OAuth2Adapter',
                    'storage' => [
                        'storage' => 'oauth2.doctrineadapter.default',
                        'route' => '/oauth',
                    ],
                ],
            ],
            'map' => [
                'ApiResource\\V1' => 'oauth2_doctrine',
            ],
        ],
    ],
];
