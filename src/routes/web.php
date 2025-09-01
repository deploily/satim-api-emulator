<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
*/

// Ta route existante
Route::get('paymentWebpage', [PaymentController::class,'paymentWebpage']);

// 🚪 LOGIN AVEC KEYCLOAK
Route::get('/login', function () {
    return Socialite::driver('keycloak')->redirect();
})->name('login');

// 🔑 CALLBACK KEYCLOAK
Route::get('/auth/callback', function () {
    $keycloakUser = Socialite::driver('keycloak')->user();

    // Vérifier si l’utilisateur existe déjà dans ta DB Laravel
    $user = User::firstOrCreate(
        ['email' => $keycloakUser->getEmail()],
        [
            'name' => $keycloakUser->getName(),
            'password' => bcrypt(str()->random(16)), // mot de passe factice
        ]
    );

    // Connecter l’utilisateur dans Laravel
    Auth::login($user);

    return redirect()->route('dashboard');
});

// 🏠 DASHBOARD (protégé par auth)
Route::middleware('auth')->get('/dashboard', function () {
    return "Bienvenue " . Auth::user()->name;
})->name('dashboard');

// 🚪 LOGOUT
Route::get('/logout', function () {
    Auth::logout();

    $logoutUrl = env('KEYCLOAK_BASE_URL') . '/realms/' . env('KEYCLOAK_REALM') . '/protocol/openid-connect/logout?redirect_uri=' . urlencode('http://localhost:8000');

    return redirect($logoutUrl);
})->name('logout');
