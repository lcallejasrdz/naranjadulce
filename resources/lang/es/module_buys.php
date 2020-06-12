<?php

$model = "Buy";

$singular_ucfirst = "Pedido";
$singular_lcfirst = "pedido";
$plural_ucfirst = "Pedidos";

return [
    // Controller
    'controller'            => [
        'model'                 => $model,
        'select'                => [
            'id',
            'first_name',
            'last_name',
            'email',
            'status_id',
            'created_at',
        ],
        'create_fields'         => [
            'slug',
            'email',
            'first_name',
            'last_name',
            'phone',
            'postal_code',
            'state',
            'municipality',
            'colony',
            'street',
            'no_ext',
            'no_int',
            'package',
            'thematic',
            'modifications',
            'buy_message',
            'delivery_date',
            'delivery_schedule',
            'observations',
            'how_know_us',
            'how_know_us_other',
            'address_references',
            'address_type',
            'parking',
            'who_sends',
            'who_receives',
            'return_reason',
            'status_id',
        ],
        'word'                  => $plural_ucfirst,
    ],
    'publicity_message'     => 'Déjanos tu correo si deseas recibir nuestras promociones.',
    'titles'                => [
        'contact_data'          => 'Datos de contacto',
        'delivery_address'      => 'Dirección de entrega',
        'delivery_data'         => 'Datos de entrega',
    ],
    'how_know_us'           => [
        'facebook'              => 'facebook',
        'instagram'             => 'instagram',
        'recommendation'        => 'recomendación',
        'site_web'              => 'sitio web',
        'other'                 => 'otro',
    ],
    'delivery_schedule'     => [
        'early'                 => '09:00 - 12:00',
        'late'                  => '13:00 - 18:00',
        'preferential'          => 'Horario preferencial',
    ],
    'address_type'          => [
        'private'               => 'Particular',
        'business'              => 'Negocio',
        'company'               => 'Empresa',
    ],
    'parking'               => [
        'yes'                   => 'Si',
        'no'                    => 'No',
        'unknow'                => 'Desconozco',
    ],
    'thematic'               => [
        'birthdate'             => 'Cumpleaños',
        'anniversary'           => 'Aniversario',
        'love'                  => 'Amor',
        'friendship'            => 'Amistad',
        'other'                 => 'Otro',
    ],
];
