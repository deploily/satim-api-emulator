<?php

return [

   
    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    |
    | Configure le guard utilisé par Filament et la page de login.
    |
    */

    'auth' => [
        'guard' => 'web',
        'pages' => [
            'login' => \App\Filament\Pages\KeycloakLogin::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin path
    |--------------------------------------------------------------------------
    |
    | Préfixe des URLs Filament (ex: /admin)
    |
    */
    'path' => 'admin', 

    /*
    |--------------------------------------------------------------------------
    | Broadcasting
    |--------------------------------------------------------------------------
    */
    'broadcasting' => [
 
    ],

    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),
    'assets_path' => null,
    'cache_path' => base_path('bootstrap/cache/filament'),
    'livewire_loading_delay' => 'default',
    'system_route_prefix' => 'filament',
];
