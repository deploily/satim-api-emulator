<?php

return [

    // ... ton code existant ...

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    |
    | Configure le guard utilisé par Filament et la page de login.
    |
    */

    'auth' => [
        // Le guard à utiliser : si tu utilises Keycloak, mets ton guard Keycloak
        'guard' => 'web', // ou 'keycloak' si tu as configuré un guard Keycloak

        // La page de login utilisée par Filament
        'pages' => [
            // Classe de login par défaut de Filament
            //'login' => \Filament\Http\Livewire\Auth\Login::class,

            // OU si tu veux utiliser Keycloak, crée une page custom :
            'login' => \App\Filament\Pages\KeycloakLogin::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Broadcasting
    |--------------------------------------------------------------------------
    */
    'broadcasting' => [
        // ton code existant...
    ],

    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),
    'assets_path' => null,
    'cache_path' => base_path('bootstrap/cache/filament'),
    'livewire_loading_delay' => 'default',
    'system_route_prefix' => 'filament',
];
