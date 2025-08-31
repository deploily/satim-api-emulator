<?php

namespace App\Filament\Resources\PaymentResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalPayments = \App\Models\Payment::where('user_id', Auth::id())->count();
        $totalAmount = \App\Models\Payment::where('user_id', Auth::id())->sum('amount');
        $totalPayments_last_month = \App\Models\Payment::where('user_id', Auth::id())
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();
        $totalAmount_last_month = \App\Models\Payment::where('user_id', Auth::id())
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('amount');
        return [
            Stat::make('Total Payments', $totalPayments)
            ->description( $totalPayments_last_month.' were made last month' )
            ->descriptionIcon('heroicon-o-credit-card')
            ->color('success'),
            Stat::make('Total Amount', 'Dz ' . number_format($totalAmount, 2))
            ->description($totalAmount_last_month.' were made last month')
            ->descriptionIcon('heroicon-o-currency-dollar')
            ->color('success'),
        ];
    }
}
