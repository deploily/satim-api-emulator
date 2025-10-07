<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static string $view = 'filament.pages.user-profile';
    protected static ?string $title = 'My Profile';

    protected static bool $shouldRegisterNavigation = false;



    public function getUser()
    {
        return Auth::guard('web')->user();
    }
}
