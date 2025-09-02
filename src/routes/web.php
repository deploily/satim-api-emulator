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
Route::get('paymentWebpage', [PaymentController::class,'paymentWebpage']);

// LOGIN AVEC KEYCLOAK
Route::get('/login', function () {
    $keycloakBaseUrl = env('KEYCLOAK_BASE_URL'); 
    $realm = env('KEYCLOAK_REALM'); 
    $clientId = env('KEYCLOAK_CLIENT_ID'); 
    $redirectUri = urlencode(env('KEYCLOAK_REDIRECT_URI')); 
    $scope = 'openid';
    $responseType = 'code';
    $state = bin2hex(random_bytes(16));

    $url = "{$keycloakBaseUrl}/realms/{$realm}/protocol/openid-connect/auth?client_id={$clientId}&redirect_uri={$redirectUri}&scope={$scope}&response_type={$responseType}&state={$state}";

    return redirect($url);
})->name('login');

// CALLBACK KEYCLOAK avec debug
Route::get('/callback', function () {
    try {
      
        $keycloakUser = Socialite::driver('keycloak')->stateless()->user();

        dd($keycloakUser);
    } catch (\Exception $e) {
        dd($e->getMessage(), $e->getTraceAsString()); 
    }

    $user = User::firstOrCreate(
        ['email' => $keycloakUser->getEmail()],
        ['name' => $keycloakUser->getName(), 'password' => bcrypt(str()->random(16))]
    );

    Auth::login($user);

    return redirect()->route('dashboard');
});

// DASHBOARD (protégé par auth)
Route::middleware('auth')->get('/dashboard', function () {
    return "Bienvenue " . Auth::user()->name;
})->name('dashboard');

// 🚪 LOGOUT
Route::get('/logout', function () {
    Auth::logout();

    $logoutUrl = env('KEYCLOAK_BASE_URL') . '/realms/' . env('KEYCLOAK_REALM') . '/protocol/openid-connect/logout?redirect_uri=' . urlencode('http://localhost:8000');

    return redirect($logoutUrl);
})->name('logout');

// Route attendue par Filament
Route::get('/filament/login', function () {
    return redirect()->route('login'); 
})->name('filament.admin.auth.login');
