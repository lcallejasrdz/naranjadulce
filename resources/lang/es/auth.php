<?php

$model = "User";

$singular_ucfirst = "Login";
$singular_lcfirst = "login";

return [
    'word'              => $singular_ucfirst,
    'title'             => 'Bienvenido!',
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed'   => 'Estas credenciales no coinciden con nuestros registros.',
    'throttle' => 'Demasiados intentos de acceso. Por favor intente nuevamente en :seconds segundos.',

    // Auth
    'login'             => [
        'success'           => 'Inicio de sesión exitoso.',
        'error'             => 'Estas credenciales no coinciden con nuestros registros.',
    ],
    'logout'            => [
        'question'          => '¿Seguro que deseas cerrar sesión?',
        'message'           => 'Presiona el botón "Logout" si estás listo para cerrar la sesión.',
        'title'             => 'Cerrar sesión',
        'cancel'            => 'Cancelar',
        'success'           => 'Sesión cerrada exitosamente.',
        'error'             => 'Error al cerrar tu sesión.',
    ],
    'submit'            => 'Iniciar sesión',
];
