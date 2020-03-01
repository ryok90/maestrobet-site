<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Identidade\\V1\\Rest\\Usuario\\UsuarioResource' => 'Identidade\\V1\\Rest\\Usuario\\UsuarioResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'identidade.rest.usuario' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/usuario[/:usuario_id]',
                    'defaults' => array(
                        'controller' => 'Identidade\\V1\\Rest\\Usuario\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'identidade.rest.usuario',
        ),
    ),
    'zf-rest' => array(
        'Identidade\\V1\\Rest\\Usuario\\Controller' => array(
            'listener' => 'Identidade\\V1\\Rest\\Usuario\\UsuarioResource',
            'route_name' => 'identidade.rest.usuario',
            'route_identifier_name' => 'usuario_id',
            'collection_name' => 'usuario',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Usuario\\Entity\\Usuario',
            'collection_class' => 'Identidade\\V1\\Rest\\Usuario\\UsuarioCollection',
            'service_name' => 'Usuario',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Identidade\\V1\\Rest\\Usuario\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Identidade\\V1\\Rest\\Usuario\\Controller' => array(
                0 => 'application/vnd.identidade.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Identidade\\V1\\Rest\\Usuario\\Controller' => array(
                0 => 'application/vnd.identidade.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Identidade\\V1\\Rest\\Usuario\\UsuarioEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identidade.rest.usuario',
                'route_identifier_name' => 'usuario_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'Identidade\\V1\\Rest\\Usuario\\UsuarioCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identidade.rest.usuario',
                'route_identifier_name' => 'usuario_id',
                'is_collection' => true,
            ),
            'Usuario\\Entity\\Usuario' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'identidade.rest.usuario',
                'route_identifier_name' => 'usuario_id',
                'hydrator' => 'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject',
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Identidade\\V1\\Rest\\Usuario\\Controller' => array(
            'input_filter' => 'Identidade\\V1\\Rest\\Usuario\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Identidade\\V1\\Rest\\Usuario\\Validator' => array(
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
                'description' => 'Endereço de Email',
                'error_message' => 'Insira seu endereço de e-mail válido',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '256',
                            'min' => '5',
                        ),
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
                'error_message' => 'Nome obrigatório',
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
                'error_message' => 'Apelido obrigatório',
            ),
        ),
    ),
);
