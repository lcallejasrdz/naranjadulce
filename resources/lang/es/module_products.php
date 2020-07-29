<?php

$model = "Product";

$singular_ucfirst = "Producto";
$singular_lcfirst = "producto";
$plural_ucfirst = "Almacén";

return [
    // Controller
    'controller'            => [
        'model'                 => $model,
        'select'                => [
            'id',
            'code',
            'category',
            'product_name',
            'created_at',
        ],
        'word'                  => $plural_ucfirst,
        'create_word'           => 'Agregar '.$singular_lcfirst,
        'edit_word'             => 'Editar '.$singular_lcfirst,
        'deleted_word'          => $plural_ucfirst.' eliminadas',
    ],
    'delivery_type'         => [
        'normal'                => 'normal',
        'special'               => 'preferencial',
    ],
    // Sidebar
    'sidebar'               => [
        'route_title_singular'  => $singular_ucfirst,
        'route_title_plural'    => $plural_ucfirst,
        'route_font_awesome'    => 'warehouse',
        'title'                 => 'Agregar',
    ],
];
