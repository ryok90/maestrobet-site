<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Identity\\V1\\Rest\\Usuario\\UsuarioResource' => 'Identity\\V1\\Rest\\Usuario\\UsuarioResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'identity.rest.usuario' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/usuario[/:usuario_id]',
                    'defaults' => array(
                        'controller' => 'Identity\\V1\\Rest\\Usuario\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'identity.rest.usuario',
        ),
    ),
    'zf-rest' => array(
        'Identity\\V1\\Rest\\Usuario\\Controller' => array(
            'listener' => 'Identity\\V1\\Rest\\Usuario\\UsuarioResource',
            'route_name' => 'identity.rest.usuario',
            'route_identifier_name' => 'usuario_id',
            'collection_name' => 'usuario',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'POST',
                1 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Usuario\\Entity\\Usuario',
            'collection_class' => 'Identity\\V1\\Rest\\Usuario\\UsuarioCollection',
            'service_name' => 'Usuario',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Identity\\V1\\Rest\\Usuario\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Identity\\V1\\Rest\\Usuario\\Controller' => array(
                0 => 'application/vnd.identity.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Identity\\V1\\Rest\\Usuario\\Controller' => array(
                0 => 'application/vnd.identity.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Identity\\V1\\Rest\\Usuario\\UsuarioEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identity.rest.usuario',
                'route_identifier_name' => 'usuario_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'Identity\\V1\\Rest\\Usuario\\UsuarioCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identity.rest.usuario',
                'route_identifier_name' => 'usuario_id',
                'is_collection' => true,
            ),
            'Usuario\\Entity\\Usuario' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identity.rest.usuario',
                'route_identifier_name' => 'usuario_id',
                'hydrator' => 'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject',
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Identity\\V1\\Rest\\Usuario\\Controller' => array(
            'input_filter' => 'Identity\\V1\\Rest\\Usuario\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Identity\\V1\\Rest\\Usuario\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\EmailAddress',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'email',
                'description' => 'Endereço de e-mail',
                'error_message' => 'Insira seu endereço de e-mail válido',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'senha',
                'description' => 'Senha',
                'error_message' => 'Insira a senha',
            ),
            2 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'nome',
                'description' => 'Nome completo',
                'error_message' => 'Insira o nome completo',
            ),
            3 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'apelido',
                'description' => 'Apelido',
                'error_message' => 'Insira o apelido',
            ),
            4 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(),
                'name' => 'roles',
                'description' => 'Roles',
                'field_type' => 'array',
                'error_message' => 'Roles',
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Identity\\V1\\Rest\\Usuario\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
            ),
        ),
    ),
);
