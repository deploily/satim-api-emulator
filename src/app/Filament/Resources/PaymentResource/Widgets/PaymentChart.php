<?php

namespace App\Filament\Resources\PaymentResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class PaymentChart extends ChartWidget
{
    protected static ?string $heading = 'Payments Over Time';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Payments',
                    'data' => \App\Models\Payment::where('user_id', Auth::id())
                        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                        ->groupBy('date')
                        ->pluck('count')
                        ->toArray(),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => \App\Models\Payment::where('user_id', Auth::id())
                ->selectRaw('DATE(created_at) as date')
                ->groupBy('date')
                ->pluck('date')
                ->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
