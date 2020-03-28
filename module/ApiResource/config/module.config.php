<?php
return array(
    'doctrine-hydrator' => array(
        'LancamentoHydrator' => array(
            'entity_class' => 'Financeiro\\Entity\\Lancamento',
            'object_manager' => 'Doctrine\\ORM\\EntityManager',
            'by_value' => true,
        ),
        'UsuarioHydrator' => array(
            'entity_class' => 'Usuario\\Entity\\Usuario',
            'object_manager' => 'Doctrine\\ORM\\EntityManager',
            'by_value' => true,
            'filters' => array(
                'usuario_filter' => array(
                    'condition' => 'and',
                    'filter' => 'UsuarioFilter',
                ),
            ),
        ),
    ),
    'hydrators' => array(
        'aliases' => array(
            'Financeiro\\Entity\\Lancamento' => 'LancamentoHydrator',
            'Usuario\\Entity\\Usuario' => 'UsuarioHydrator',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'UsuarioFilter' => 'Usuario\\HydratorFilter\\UsuarioFilter',
        ),
        'factories' => array(
            'ApiResource\\V1\\Rest\\Usuario\\UsuarioResource' => 'ApiResource\\V1\\Rest\\Usuario\\UsuarioResourceFactory',
            'ApiResource\\V1\\Rest\\Lancamento\\LancamentoResource' => 'ApiResource\\V1\\Rest\\Lancamento\\LancamentoResourceFactory',
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
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'api-resource.rest.usuario',
            1 => 'api-resource.rest.lancamento',
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
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'ApiResource\\V1\\Rest\\Usuario\\Controller' => 'HalJson',
            'ApiResource\\V1\\Rest\\Lancamento\\Controller' => 'HalJson',
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
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
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
                'hydrator' => 'UsuarioHydrator',
                'max_depth' => 1,
            ),
            'ApiResource\\V1\\Rest\\Lancamento\\LancamentoCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api-resource.rest.lancamento',
                'route_identifier_name' => 'lancamento_id',
                'is_collection' => true,
            ),
            'Financeiro\\Entity\\Lancamento' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api-resource.rest.lancamento',
                'route_identifier_name' => 'lancamento_id',
                'hydrator' => 'LancamentoHydrator',
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
        ),
    ),
);
