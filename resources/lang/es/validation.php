<?php

return [
    'accepted' => 'El campo :attribute debe ser aceptado.',
    'active_url' => 'El campo :attribute no es una URL válida.',
    'email' => 'El correo electrónico debe ser una dirección válida.',
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'required' => 'El campo :attribute es obligatorio.',
    
    'custom' => [
        'email' => [
            'required' => 'El correo electrónico es obligatorio.',
            'email' => 'Debe ingresar un correo electrónico válido.',
        ],
        'password' => [
            'required' => 'La contraseña es obligatoria.',
            'min' => 'La contraseña debe tener al menos :min caracteres.',
        ],
    ],
    
    'attributes' => [
        'email' => 'correo electrónico',
        'password' => 'contraseña',
    ],
];
