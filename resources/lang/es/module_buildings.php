<?php

$model = "Building";

$singular_ucfirst = "Confirmación de paquete";
$singular_lcfirst = "confirmación de paquete";
$plural_ucfirst = "Paquetes";

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
            'user_id',
            'verified_building',
        ],
        'word'                  => $plural_ucfirst,
        'create_word'           => 'Agregar '.$singular_lcfirst,
        'edit_word'             => 'Editar '.$singular_lcfirst,
        'deleted_word'          => $plural_ucfirst.' eliminados',
    ],
    // Sidebar
    'sidebar'               => [
        'route_title_singular'  => $singular_ucfirst,
        'route_title_plural'    => $plural_ucfirst,
        'route_font_awesome'    => 'shopping-basket',
    ],
];
