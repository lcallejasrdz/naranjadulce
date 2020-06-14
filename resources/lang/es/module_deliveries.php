<?php

$model = "Delivery";

$singular_ucfirst = "Confirmación de entrega";
$singular_lcfirst = "confirmación de entrega";
$plural_ucfirst = "Entregas";

return [
    // Controller
    'controller'            => [
        'model'                 => $model,
        'select'                => [
            'id',
            'first_name',
            'last_name',
            'delivery_date',
            'created_at',
        ],
        'create_fields'         => [
            'slug',
            'user_id',
            'verified_delivered',
        ],
        'word'                  => $plural_ucfirst,
        'create_word'           => 'Agregar '.$singular_lcfirst,
        'edit_word'             => 'Editar '.$singular_lcfirst,
        'deleted_word'          => $plural_ucfirst.' eliminadas',
    ],
    // Sidebar
    'sidebar'               => [
        'route_title_singular'  => $singular_ucfirst,
        'route_title_plural'    => $plural_ucfirst,
        'route_font_awesome'    => 'truck-loading',
        'finished'              => 'Terminadas',
    ],
];
