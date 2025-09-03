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
    return Socialite::driver('keycloak')->redirect();
})->name('login');



Route::get('/auth/keycloak/callback', function () {
    try {
        $keycloakUser = Socialite::driver('keycloak')->stateless()->user();
        dd($keycloakUser);
    } catch (\Exception $e) {
        dd($e->getMessage(), $e->getTraceAsString()); 
    }
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
