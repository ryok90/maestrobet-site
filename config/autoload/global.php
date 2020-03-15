<?php
return array(
    'doctrine' => array(
        'migrations_configuration' => array(
            'orm_default' => array(
                'directory' => 'data/Migrations',
                'name' => 'Doctrine Database Migrations',
                'namespace' => 'Migrations',
                'table' => 'migrations',
            ),
        ),
    ),
    'zf-oauth2' => array(
        'storage' => 'oauth2.doctrineadapter.default',
    ),
    'zf-mvc-auth' => array(
        'authentication' => array(
            'adapters' => array(
                'oauth2_doctrine' => array(
                    'adapter' => 'ZF\\MvcAuth\\Authentication\\OAuth2Adapter',
                    'storage' => array(
                        'storage' => 'oauth2.doctrineadapter.default',
                        'route' => '/oauth',
                    ),
                ),
            ),
            'map' => array(
                'Identidade\\V1' => 'oauth2_doctrine',
                'Identity\\V1' => 'oauth2_doctrine',
            ),
        ),
    ),
);
