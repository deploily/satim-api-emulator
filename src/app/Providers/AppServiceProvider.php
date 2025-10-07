<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Keycloak\Provider as KeycloakProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Surcharge la config pour s'assurer que le realm est bien celui défini dans .env
        config([
            'services.keycloak.realm' => env('KEYCLOAK_REALM', 'satim'),
        ]);

        // Redéfinition du provider Keycloak
        Socialite::extend('keycloak', function ($app) {
            $config   = $app['config']['services.keycloak'];
            $baseUrl  = rtrim($config['base_url'], '/');   // Nettoie l'URL de base
            $realm    = $config['realms'];

            return Socialite::buildProvider(KeycloakProvider::class, [
                'client_id'     => $config['client_id'],
                'client_secret' => $config['client_secret'],
                'redirect'      => $config['redirect'],
                'base_url'      => $baseUrl,
                'realms'         => $realm,

                // Endpoints Keycloak corrects
                'authorize'     => "{$baseUrl}/realms/{$realm}/protocol/openid-connect/auth",
                'token'         => "{$baseUrl}/realms/{$realm}/protocol/openid-connect/token",
                'userinfo'      => "{$baseUrl}/realms/{$realm}/protocol/openid-connect/userinfo",
                'logout'        => "{$baseUrl}/realms/{$realm}/protocol/openid-connect/logout",
            ]);
        });
    }
}
