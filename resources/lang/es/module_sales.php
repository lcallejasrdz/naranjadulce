<?php

$model = "Sale";

$singular_ucfirst = "Venta";
$singular_lcfirst = "comprobante";
$plural_ucfirst = "Ventas";

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
            'status_id',
            'created_at',
        ],
        'create_fields'         => [
            'slug',
            'user_id',
            'proof_of_payment',
            'quantity',
            'seller_package',
            'seller_modifications',
            'delivery_type',
            'preferential_schedule',
            'observations_finances',
            'observations_buildings',
            'observations_shippings',
            'shipping_cost',
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
        'route_font_awesome'    => 'shopping-cart',
        'title'                 => 'Por confirmar',
        'finished'              => 'Terminadas',
    ],
];
