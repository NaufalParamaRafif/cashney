<?php

namespace App\Filament\Widgets;

use App\Models\TransactionDetail;
use Carbon\Carbon;
use Filament\Widgets\BarChartWidget;

class UserGrowthCharte extends BarChartWidget
{
    protected static ?string $heading = 'Produk Terjual (7 Hari Terakhir)';

    protected function getData(): array
    {
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $label = Carbon::now()->subDays($i)->format('d M');

            $total = TransactionDetail::whereDate('created_at', $date)->sum('product_total');

            $data[] = [
                'label' => $label,
                'total' => $total,
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Produk Terjual',
                    'data' => collect($data)->pluck('total'),
                    'backgroundColor' => '#22c55e',
                ],
            ],
            'labels' => collect($data)->pluck('label')->toArray(),
        ];
    }
}
