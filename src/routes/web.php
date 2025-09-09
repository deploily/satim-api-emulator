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

// Login avec Keycloak
Route::get('/login', [KeycloakController::class, 'redirect'])->name('login');
Route::get('/auth/keycloak/callback', [KeycloakController::class, 'callback']);


// Logout
Route::get('/logout', [KeycloakController::class, 'logout'])->name('logout');

// Filament
Route::get('/filament/login', fn() => redirect()->route('login'))
    ->name('filament.admin.auth.login');

Route::match(['get', 'post'], '/filament/logout', [KeycloakController::class, 'logout'])
    ->name('filament.logout');

Route::middleware(['auth:web']) 
    ->get('/admin/user-profile', UserProfile::class)
    ->name('admin.user-profile');
