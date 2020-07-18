<?php

$model = "Sale";

$singular_ucfirst = "Canasta Rosa";
$singular_lcfirst = "Canasta Rosa";
$plural_ucfirst = "Canasta Rosa";

return [
    // Controller
    'controller'            => [
        'model'                 => $model,
        'select'                => [
            'id',
            'first_name',
            'last_name',
            'package',
            'delivery_date',
            'nd_status_id',
            'created_at',
        ],
        'word'                  => $plural_ucfirst,
        'create_word'           => 'Agregar '.$singular_lcfirst,
        'edit_word'             => 'Editar '.$singular_lcfirst,
        'deleted_word'          => $plural_ucfirst.' eliminada',
    ],
    // Sidebar
    'sidebar'               => [
        'route_title_singular'  => $singular_ucfirst,
        'route_title_plural'    => $plural_ucfirst,
        'route_font_awesome'    => 'shopping-cart',
        'title'                 => 'Canasta Rosa',
        'finished'              => 'Terminadas',
    ],
];
