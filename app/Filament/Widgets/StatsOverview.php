<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Customer;
use App\Models\Product;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            // buatkan card total penjualan seluruh produk hari ini
            Card::make('Total Penjualan', 'Rp ' . number_format(Transaction::sum('price_total')))
                ->description('Jumlah seluruh penjualan')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),

            Card::make('Pelanggan Baru', Customer::whereDate('created_at', now())->count())
                ->description('Hari ini')
                ->descriptionIcon('heroicon-o-user-plus')
                ->color('info'),

            // dd(TransactionDetail::whereDate('created_at', now()));
            Card::make(
                    'Total Produk Terjual Hari Ini', 
                    TransactionDetail::whereHas('transaction', function($query) {
                        $query->whereDate('created_at', now());
                    })->sum('product_total') . ' Item'
                )
                ->description('Semua produk yang terjual hari ini')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('warning'),
        ];
    }
}
