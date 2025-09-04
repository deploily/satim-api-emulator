<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class KeycloakController extends Controller
{
    // Redirection vers Keycloak
    public function redirect()
    {
        return Socialite::driver('keycloak')->redirect();
    }

    // Callback depuis Keycloak
    public function callback()
    {
        try {
            $keycloakUser = Socialite::driver('keycloak')->stateless()->user();

            // ✅ Stocker l'id_token en session (important pour le logout)
            $idToken = $keycloakUser->accessTokenResponseBody['id_token'] ?? null;
            session(['keycloak_id_token' => $idToken]);

            // Enregistrement automatique ou récupération du user Laravel
            $user = User::firstOrCreate(
                ['email' => $keycloakUser->getEmail()],
                [
                    'name' => $keycloakUser->getName() ?? $keycloakUser->getNickname(),
                    'password' => bcrypt(str()->random(16)),
                ]
            );

            // Connexion Laravel
            Auth::login($user);

            return redirect('/'); // page principale après login
        } catch (\Exception $e) {
            return redirect('/')->withErrors(['login' => $e->getMessage()]);
        }
    }

    // Déconnexion
    public function logout()
    {
        $idToken = session('keycloak_id_token');

        // Déconnexion Laravel
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // Déconnexion Keycloak + redirection vers /login
        $params = [];
        if ($idToken) {
            $params['id_token_hint'] = $idToken;
        }
        $params['post_logout_redirect_uri'] = url('/login');

        $logoutUrl = env('KEYCLOAK_BASE_URL') . '/realms/' . env('KEYCLOAK_REALM') 
                     . '/protocol/openid-connect/logout?' . http_build_query($params);

        return redirect($logoutUrl);
    }
}
