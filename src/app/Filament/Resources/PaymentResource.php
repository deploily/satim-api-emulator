<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('orderNumber')
                    ->required()
                    ->numeric(),

                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),

                Forms\Components\TextInput::make('currency')
                    ->required(),

                Forms\Components\TextInput::make('returnUrl')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('failUrl')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\Toggle::make('isConfirmed')
                    ->label('Confirmed')
                    ->default(false),

                Forms\Components\Toggle::make('isFailed')
                    ->label('Failed')
                    ->default(false),

                Forms\Components\Hidden::make('user_id')
                    ->default(fn () => Auth::id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('orderNumber')->sortable(),
                Tables\Columns\TextColumn::make('amount')->sortable(),
                Tables\Columns\TextColumn::make('currency'),
                Tables\Columns\TextColumn::make('returnUrl')->limit(30),
                Tables\Columns\TextColumn::make('failUrl')->limit(30),
                Tables\Columns\IconColumn::make('isConfirmed')
                    ->boolean(),
                Tables\Columns\IconColumn::make('isFailed')
                    ->boolean(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'view'   => Pages\ViewPayment::route('/{record}'),
        ];
    }

    /**
     * Filtrer les paiements selon l’utilisateur
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id());
    }
    
    
}
