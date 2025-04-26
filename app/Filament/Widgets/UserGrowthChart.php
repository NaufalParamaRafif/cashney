<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Carbon\Carbon;
use Filament\Widgets\BarChartWidget;

class UserGrowthChart extends BarChartWidget
{
    protected static ?string $heading = 'Pertumbuhan User (7 Hari Terakhir)';

    protected function getData(): array
    {
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();

            $count = Customer::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

            $data[] = [
                'label' => $startOfWeek->format('d M'),
                'count' => $count,
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'User Baru',
                    'data' => collect($data)->pluck('count'),
                    'backgroundColor' => '#ef4444',
                ],
            ],
            'labels' => collect($data)->pluck('label')->toArray(),
        ];
    }
}
