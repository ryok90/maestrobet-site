<?php
return array(
    'Identidade\\V1\\Rest\\Usuario\\Controller' => array(
        'collection' => array(
            'POST' => array(
                'request' => '{
   "email": "Endereço de Email",
   "senha": "Senha"
}',
                'response' => '',
            ),
            'description' => 'Registrar novo usuário',
        ),
        'description' => 'Usuário Service',
    ),
);
