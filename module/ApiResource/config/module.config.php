<?php
return array(
    'service_manager' => array(
        'invokables' => array(
            'UsuarioFilter' => 'Usuario\\HydratorFilter\\UsuarioFilter',
        ),
        'factories' => array(
            'ApiResource\\V1\\Rest\\Usuario\\UsuarioResource' => 'ApiResource\\V1\\Rest\\Usuario\\UsuarioResourceFactory',
            'ApiResource\\V1\\Rest\\Lancamento\\LancamentoResource' => 'ApiResource\\V1\\Rest\\Lancamento\\LancamentoResourceFactory',
            'ApiResource\\V1\\Rest\\Extrato\\ExtratoResource' => 'ApiResource\\V1\\Rest\\Extrato\\ExtratoResourceFactory',
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
            'api-resource.rest.lancamento' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/usuario/:usuario_id/lancamento[/:lancamento_id]',
                    'defaults' => array(
                        'controller' => 'ApiResource\\V1\\Rest\\Lancamento\\Controller',
                    ),
                ),
            ),
            'api-resource.rest.extrato' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/usuario/:usuario_id/extrato[/:extrato_id]',
                    'defaults' => array(
                        'controller' => 'ApiResource\\V1\\Rest\\Extrato\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'api-resource.rest.usuario',
            1 => 'api-resource.rest.lancamento',
            2 => 'api-resource.rest.extrato',
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
                1 => 'PATCH',
                2 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'POST',
                1 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Usuario\\Entity\\Usuario',
            'collection_class' => 'ApiResource\\V1\\Rest\\Usuario\\UsuarioCollection',
            'service_name' => 'Usuario',
        ),
        'ApiResource\\V1\\Rest\\Lancamento\\Controller' => array(
            'listener' => 'ApiResource\\V1\\Rest\\Lancamento\\LancamentoResource',
            'route_name' => 'api-resource.rest.lancamento',
            'route_identifier_name' => 'lancamento_id',
            'collection_name' => 'lancamento',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'POST',
            ),
            'collection_http_methods' => array(
                0 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Financeiro\\Entity\\Lancamento',
            'collection_class' => 'ApiResource\\V1\\Rest\\Lancamento\\LancamentoCollection',
            'service_name' => 'Lancamento',
        ),
        'ApiResource\\V1\\Rest\\Extrato\\Controller' => array(
            'listener' => 'ApiResource\\V1\\Rest\\Extrato\\ExtratoResource',
            'route_name' => 'api-resource.rest.extrato',
            'route_identifier_name' => 'extrato_id',
            'collection_name' => 'extrato',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Financeiro\\Entity\\Extrato',
            'collection_class' => 'ApiResource\\V1\\Rest\\Extrato\\ExtratoCollection',
            'service_name' => 'Extrato',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'ApiResource\\V1\\Rest\\Usuario\\Controller' => 'Json',
            'ApiResource\\V1\\Rest\\Lancamento\\Controller' => 'Json',
            'ApiResource\\V1\\Rest\\Extrato\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'ApiResource\\V1\\Rest\\Usuario\\Controller' => array(
                0 => 'application/vnd.api-resource.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
                3 => 'multipart/form-data',
            ),
            'ApiResource\\V1\\Rest\\Lancamento\\Controller' => array(
                0 => 'application/vnd.api-resource.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
                3 => 'multipart/form-data',
            ),
            'ApiResource\\V1\\Rest\\Extrato\\Controller' => array(
                0 => 'application/vnd.api-resource.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'ApiResource\\V1\\Rest\\Usuario\\Controller' => array(
                0 => 'application/vnd.api-resource.v1+json',
                1 => 'application/json',
                2 => 'multipart/form-data',
            ),
            'ApiResource\\V1\\Rest\\Lancamento\\Controller' => array(
                0 => 'application/vnd.api-resource.v1+json',
                1 => 'application/json',
                2 => 'multipart/form-data',
            ),
            'ApiResource\\V1\\Rest\\Extrato\\Controller' => array(
                0 => 'application/vnd.api-resource.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'ApiResource\\V1\\Rest\\Usuario\\UsuarioCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api-resource.rest.usuario',
                'route_identifier_name' => 'usuario_id',
                'is_collection' => true,
                'max_depth' => 0,
            ),
            'Usuario\\Entity\\Usuario' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api-resource.rest.usuario',
                'route_identifier_name' => 'usuario_id',
                'hydrator' => 'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject',
                'max_depth' => 0,
            ),
            'ApiResource\\V1\\Rest\\Lancamento\\LancamentoCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api-resource.rest.lancamento',
                'route_identifier_name' => 'lancamento_id',
                'is_collection' => true,
                'max_depth' => 0,
            ),
            'Financeiro\\Entity\\Lancamento' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api-resource.rest.lancamento',
                'route_identifier_name' => 'lancamento_id',
                'hydrator' => 'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject',
                'max_depth' => 0,
            ),
            'ApiResource\\V1\\Rest\\Extrato\\ExtratoCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api-resource.rest.extrato',
                'route_identifier_name' => 'extrato_id',
                'is_collection' => true,
                'max_depth' => 0,
            ),
            'Financeiro\\Entity\\Extrato' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api-resource.rest.extrato',
                'route_identifier_name' => 'extrato_id',
                'hydrator' => 'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject',
                'max_depth' => 0,
            ),
        ),
    ),
    'controllers' => array(
        'factories' => array(),
    ),
    'zf-rpc' => array(),
    'zf-content-validation' => array(
        'ApiResource\\V1\\Rest\\Usuario\\Controller' => array(
            'input_filter' => 'ApiResource\\V1\\Rest\\Usuario\\Validator',
        ),
        'ApiResource\\V1\\Rest\\Lancamento\\Controller' => array(
            'input_filter' => 'ApiResource\\V1\\Rest\\Lancamento\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'ApiResource\\V1\\Rest\\Usuario\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => '3',
                            'max' => '64',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'nome',
                'description' => 'Nome completo',
                'field_type' => 'string',
                'error_message' => 'Campo Nome obrigatório',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => '3',
                            'max' => '64',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'apelido',
                'description' => 'Apelido',
                'field_type' => 'string',
                'error_message' => 'Campo Apelido obrigatório',
            ),
            2 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '64',
                        ),
                    ),
                    1 => array(
                        'name' => 'Zend\\Validator\\EmailAddress',
                        'options' => array(),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'email',
                'description' => 'E-mail',
                'field_type' => 'string',
                'error_message' => 'Campo e-mail obrigatório',
            ),
            3 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => '6',
                            'max' => '64',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'senha',
                'description' => 'Senha',
                'field_type' => 'string',
                'error_message' => 'Senha obrigatória',
            ),
            4 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'roles',
                'field_type' => 'array',
                'description' => 'Papéis do usuário',
                'error_message' => 'Ao menos um papel deve ser especificado',
            ),
            5 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'name' => 'isAgente',
                'field_type' => 'boolean',
                'allow_empty' => true,
            ),
            6 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'name' => 'isCliente',
                'allow_empty' => true,
                'field_type' => 'boolean',
            ),
            7 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'name' => 'isBanca',
                'allow_empty' => true,
                'field_type' => 'boolean',
            ),
            8 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'name' => 'isRepasse',
                'allow_empty' => true,
                'field_type' => 'boolean',
            ),
        ),
        'ApiResource\\V1\\Rest\\Lancamento\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\I18n\\Validator\\IsFloat',
                        'options' => array(),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\ToFloat',
                        'options' => array(),
                    ),
                ),
                'name' => 'valor',
                'description' => 'Valor do lançamento',
                'field_type' => 'integer',
            ),
            1 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '256',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'descricao',
                'description' => 'Descricao do lançamento',
                'field_type' => 'string',
            ),
            2 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\I18n\\Validator\\DateTime',
                        'options' => array(
                            'pattern' => 'Y-m-d',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\DateTimeFormatter',
                        'options' => array(
                            'format' => 'Y-m-d',
                        ),
                    ),
                ),
                'name' => 'dataLancamento',
                'description' => 'Data do lancamento',
                'field_type' => 'datetime',
            ),
            3 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'usuario',
                'description' => 'usuario',
                'field_type' => 'int',
                'error_message' => 'invalid data',
            ),
            4 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'tipo',
                'description' => 'Tipo de Lançamento',
                'field_type' => 'string',
                'error_message' => 'Tipo de lançamento invalido',
            ),
        ),
    ),
);
