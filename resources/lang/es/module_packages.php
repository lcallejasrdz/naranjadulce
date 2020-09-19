<?php

$model = "Package";

$singular_ucfirst = "Paquete";
$singular_lcfirst = "paquete";
$plural_ucfirst = "Paquetes";

return [
    // Controller
    'controller'            => [
        'model'                 => $model,
        'select'                => [
            'id',
            'name',
            'price',
            'created_at',
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
        'route_font_awesome'    => 'box-open',
        'title'                 => 'Agregar',
    ],
];
