<?php
namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use Illuminate\Support\HtmlString;
class UserProfileWidget extends BaseWidget
{
    protected static ?string $heading = 'Profile Information';
    protected int | string | array $columnSpan = 2; // half width

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()->where('id', Auth::id())
            )
            ->columns([
                Tables\Columns\TextColumn::make('satim_username')
                    ->label(new HtmlString('<span style="color: #3b82f6;">Satim Username</span>'))
                    ->extraHeaderAttributes(['class' => 'text-info-500']),
                Tables\Columns\TextColumn::make('satim_password')
                    ->label(new HtmlString('<span style="color: #3b82f6;">Satim Password</span>'))
                    ->extraHeaderAttributes(['style' => 'color: #3b82f6;']),
                Tables\Columns\TextColumn::make('terminal_id')
                    ->label(new HtmlString('<span style="color: #3b82f6;">Terminal ID</span>'))
            ])
            ->paginated(false);
    }
}