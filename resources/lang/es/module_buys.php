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
            'modifications',
            'buy_message',
            'delivery_date',
            'delivery_schedule',
            'how_know_us',
            'how_know_us_other',
        ],
        'word'                  => $plural_ucfirst,
    ],
    'how_know_us'           => [
        'facebook'              => 'facebook',
        'instagram'             => 'instagram',
        'recommendation'        => 'recomendación',
        'site_web'              => 'sitio web',
        'other'                 => 'otro',
    ],
    'delivery_schedule'           => [
        'early'             => '09:00 - 12:00',
        'late'              => '13:00 - 18:00',
    ],
];
