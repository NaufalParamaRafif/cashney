<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Tables\Actions\Action::make('export_excel')
                ->label('Export Excel')
                ->icon('heroicon-o-download')
                ->url(route('transactions.export'))
                ->color('primary'),
        ];
    }
}
