<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_excel')
                ->label('Export Excel')
                ->url(route('transactions.export'))
                ->openUrlInNewTab()  // Penting untuk download di tab baru
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray'),
        ];
    }
}