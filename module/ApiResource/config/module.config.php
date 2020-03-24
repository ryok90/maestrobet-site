<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'ApiResource\\V1\\Rest\\Usuario\\UsuarioResource' => 'ApiResource\\V1\\Rest\\Usuario\\UsuarioResourceFactory',
            'ApiResource\\V1\\Rest\\Debito\\DebitoResource' => 'ApiResource\\V1\\Rest\\Debito\\DebitoResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'api-resource.rest.usuario' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/usuario[/:usuario_id]',
                    'defaults' => array(
                        'controller' => 'ApiResource\\V1\\Rest\\Usuario\\Controller',
                    ),
                ),
            ),
            'api-resource.rest.debito' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/debito[/:debito_id]',
                    'defaults' => array(
                        'controller' => 'ApiResource\\V1\\Rest\\Debito\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'api-resource.rest.usuario',
            1 => 'api-resource.rest.debito',
        ),
    ),
    'zf-rest' => array(
        'ApiResource\\V1\\Rest\\Usuario\\Controller' => array(
            'listener' => 'ApiResource\\V1\\Rest\\Usuario\\UsuarioResource',
            'route_name' => 'api-resource.rest.usuario',
            'route_identifier_name' => 'usuario_id',
            'collection_name' => 'usuario',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
                2 => 'PUT',
                3 => 'PATCH',
                4 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Usuario\\Entity\\Usuario',
            'collection_class' => 'ApiResource\\V1\\Rest\\Usuario\\UsuarioCollection',
            'service_name' => 'Usuario',
        ),
        'ApiResource\\V1\\Rest\\Debito\\Controller' => array(
            'listener' => 'ApiResource\\V1\\Rest\\Debito\\DebitoResource',
            'route_name' => 'api-resource.rest.debito',
            'route_identifier_name' => 'debito_id',
            'collection_name' => 'debito',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'ApiResource\\V1\\Rest\\Debito\\DebitoEntity',
            'collection_class' => 'ApiResource\\V1\\Rest\\Debito\\DebitoCollection',
            'service_name' => 'Debito',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'ApiResource\\V1\\Rest\\Usuario\\Controller' => 'HalJson',
            'ApiResource\\V1\\Rest\\Debito\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'ApiResource\\V1\\Rest\\Usuario\\Controller' => array(
                0 => 'application/vnd.api-resource.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'ApiResource\\V1\\Rest\\Debito\\Controller' => array(
                0 => 'application/vnd.api-resource.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'ApiResource\\V1\\Rest\\Usuario\\Controller' => array(
                0 => 'application/vnd.api-resource.v1+json',
                1 => 'application/json',
            ),
            'ApiResource\\V1\\Rest\\Debito\\Controller' => array(
                0 => 'application/vnd.api-resource.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'ApiResource\\V1\\Rest\\Usuario\\UsuarioEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api-resource.rest.usuario',
                'route_identifier_name' => 'usuario_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'ApiResource\\V1\\Rest\\Usuario\\UsuarioCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api-resource.rest.usuario',
                'route_identifier_name' => 'usuario_id',
                'is_collection' => true,
            ),
            'Usuario\\Entity\\Usuario' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api-resource.rest.usuario',
                'route_identifier_name' => 'usuario_id',
                'hydrator' => 'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject',
            ),
            'ApiResource\\V1\\Rest\\Debito\\DebitoEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api-resource.rest.debito',
                'route_identifier_name' => 'debito_id',
                'hydrator' => 'Zend\\Hydrator\\ClassMethods',
            ),
            'ApiResource\\V1\\Rest\\Debito\\DebitoCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api-resource.rest.debito',
                'route_identifier_name' => 'debito_id',
                'is_collection' => true,
            ),
        ),
    ),
);
