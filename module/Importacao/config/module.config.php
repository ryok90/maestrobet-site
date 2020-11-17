<?php
return array(
    'controllers' => array(
        'factories' => array(
            'Importacao\\V1\\Rpc\\Usuario\\Controller' => 'Importacao\\V1\\Rpc\\Usuario\\UsuarioControllerFactory',
            'Importacao\\V1\\Rpc\\Agente\\Controller' => 'Importacao\\V1\\Rpc\\Agente\\AgenteControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'importacao.rpc.usuario' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/importacao/usuario',
                    'defaults' => array(
                        'controller' => 'Importacao\\V1\\Rpc\\Usuario\\Controller',
                        'action' => 'usuario',
                    ),
                ),
            ),
            'importacao.rpc.agente' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/importacao/agente',
                    'defaults' => array(
                        'controller' => 'Importacao\\V1\\Rpc\\Agente\\Controller',
                        'action' => 'agente',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'importacao.rpc.usuario',
            1 => 'importacao.rpc.agente',
            2 => 'importacao.rpc.agente',
            3 => 'importacao.rpc.agente',
            4 => 'importacao.rpc.agente',
        ),
    ),
    'zf-rpc' => array(
        'Importacao\\V1\\Rpc\\Usuario\\Controller' => array(
            'service_name' => 'Usuario',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'importacao.rpc.usuario',
        ),
        '' => array(
            'service_name' => 'Agente',
            'http_methods' => array(
                0 => 'GET',
                1 => 'GET',
                2 => 'GET',
            ),
            'route_name' => 'importacao.rpc.agente',
        ),
        'Importacao\\V1\\Rpc\\Agente\\Controller' => array(
            'service_name' => 'Agente',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'importacao.rpc.agente',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Importacao\\V1\\Rpc\\Usuario\\Controller' => 'HalJson',
            '' => 'Json',
            'Importacao\\V1\\Rpc\\Agente\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'Importacao\\V1\\Rpc\\Usuario\\Controller' => array(
                0 => 'application/vnd.importacao.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            '' => array(
                0 => 'application/vnd.importacao.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
                3 => 'application/vnd.importacao.v1+json',
                4 => 'application/json',
                5 => 'application/*+json',
                6 => 'application/vnd.importacao.v1+json',
                7 => 'application/json',
                8 => 'application/*+json',
            ),
            'Importacao\\V1\\Rpc\\Agente\\Controller' => array(
                0 => 'application/vnd.importacao.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'Importacao\\V1\\Rpc\\Usuario\\Controller' => array(
                0 => 'application/vnd.importacao.v1+json',
                1 => 'application/json',
            ),
            '' => array(
                0 => 'application/vnd.importacao.v1+json',
                1 => 'application/json',
                2 => 'application/vnd.importacao.v1+json',
                3 => 'application/json',
                4 => 'application/vnd.importacao.v1+json',
                5 => 'application/json',
            ),
            'Importacao\\V1\\Rpc\\Agente\\Controller' => array(
                0 => 'application/vnd.importacao.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Importacao\\V1\\Rpc\\Usuario\\Controller' => array(
            'input_filter' => 'Importacao\\V1\\Rpc\\Usuario\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Importacao\\V1\\Rpc\\Usuario\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\File\\Extension',
                        'options' => array(
                            'extension' => 'json',
                            'message' => 'Somente arquivo .json',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'usuarios',
                'description' => 'Arquivo .csv contendo usuários a serem importados
formato
nome, desconto, agente, perca, ganho, banca1, participacaoBanca1, banca2, participacaoBanca2, responsavel',
                'type' => 'Zend\\InputFilter\\FileInput',
                'field_type' => 'json',
            ),
        ),
    ),
);
