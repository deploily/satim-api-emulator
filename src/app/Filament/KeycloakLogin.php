<?php
// app/Filament/Pages/KeycloakLogin.php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class KeycloakLogin extends Page
{
    protected static string $view = 'filament.pages.keycloak-login';

    public function mount()
    {
        // Redirige vers Keycloak
        return redirect()->route('keycloak.login'); // adapte selon ta route Keycloak
    }
}
