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
           
        config([
            'services.keycloak.realm' => env('KEYCLOAK_REALM', 'satim'),
        ]);
        // Surcharge le provider Keycloak pour forcer le realm
        Socialite::extend('keycloak', function ($app) {
            $config = $app['config']['services.keycloak'];

            return Socialite::buildProvider(KeycloakProvider::class, [
                'client_id'     => $config['client_id'],
                'client_secret' => $config['client_secret'],
                'redirect'      => $config['redirect'],
                'base_url'      => $config['base_url'],
                'realm'         => $config['realm'], // <-- important, ici "satim"
            ]);
        });
    }
}
