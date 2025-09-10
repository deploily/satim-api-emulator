<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\KeycloakController;
use App\Filament\Pages\UserProfile;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
*/

// Page de paiement
Route::get('/paymentWebpage', [PaymentController::class, 'paymentWebpage'])
    ->name('payment.page');

// 🔑 Login via Keycloak
Route::get('/login/keycloak', [KeycloakController::class, 'redirect'])->name('login.keycloak');
Route::get('/auth/keycloak/callback', [KeycloakController::class, 'callback']);

// 🚪 Logout (Keycloak)
Route::match(['get', 'post'], '/logout', [KeycloakController::class, 'logout'])->name('logout');
Route::match(['get', 'post'], '/filament/logout', [KeycloakController::class, 'logout'])->name('filament.logout');

// 👤 Profil utilisateur dans Filament
Route::middleware(['auth:web'])
    ->get('/admin/user-profile', UserProfile::class)
    ->name('admin.user-profile');
