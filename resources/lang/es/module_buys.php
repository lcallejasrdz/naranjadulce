<?php

$model = "Buy";

$singular_ucfirst = "Pedido";
$singular_lcfirst = "pedido";
$plural_ucfirst = "Pedidos";

return [
    // Controller
    'controller'            => [
        'model'                 => $model,
        'word'                  => $plural_ucfirst,
    ],
    'publicity_message'     => 'Déjanos tu correo si deseas recibir nuestras promociones.',
    'titles'                => [
        'contact_data'          => 'Datos de contacto',
        'delivery_address'      => 'Dirección de entrega',
        'delivery_data'         => 'Datos de entrega',
    ],
    'modifications_message' => '(aquí escribes todos los cambios que se harán  a la sorpresa o si quieres agregar algo adicional)',
    // Sidebar
    'sidebar'               => [
        'route_title_singular'  => $singular_ucfirst,
    ],
];
