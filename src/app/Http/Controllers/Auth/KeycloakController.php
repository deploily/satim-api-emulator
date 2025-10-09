<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class KeycloakController extends Controller
{
    public function redirect()
    {
       
        return Socialite::driver('keycloak')->redirect();
    }

    public function callback()
    {
        try {
        
            $keycloakUser = Socialite::driver('keycloak')->stateless()->user();
            
            $idToken = $keycloakUser->accessTokenResponseBody['id_token'] ?? null;
            session(['keycloak_id_token' => $idToken]);

     
            $user = User::firstOrCreate(
                ['email' => $keycloakUser->getEmail()],
                [
                    'name' => $keycloakUser->getName() ?? $keycloakUser->getNickname(),
                    'password' => bcrypt(str()->random(16)),
                ]
            );
           
         
            Auth::login($user);
          
            return redirect('/'); 
        } catch (\Exception $e) {
       
            return redirect('/')->withErrors(['login' => $e->getMessage()]);
        }
    }



    public function logout()
{
    $idToken = session('keycloak_id_token');

    Auth::logout();

    session()->invalidate();
    session()->regenerateToken();

    $redirectUri = config('app.url');

    return redirect(
        Socialite::driver('keycloak')->getLogoutUrl(
            $redirectUri,
            env('KEYCLOAK_CLIENT_ID'),
            $idToken
        )
    );
}

    

}
