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
        'access_lifetime' => 86400,
        'options' => array(
            'always_issue_new_refresh_token' => true,
        ),
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
                'ApiResource\\V1' => 'oauth2_doctrine',
                'Importacao\\V1' => 'oauth2_doctrine',
            ),
        ),
    ),
);
