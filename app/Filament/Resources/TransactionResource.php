<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use function Filament\Support\format_money;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Table as TableComponent;
use App\Filament\Resources\TransactionResource\RelationManagers\TransactionDetailRelationManager;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('price_total')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return '';
                        }
                
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                    }),
                TextInput::make('cashback')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return '';
                        }
                
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                    }),
                TextInput::make('customer_email')
                    ->label('Email Pelanggan'),
                TextInput::make('cashier_email')
                    ->label('Email Kasir'),
                TextInput::make('code')
                    ->label('Kode Transaksi'),
                DatePicker::make('created_at')
                    ->format('d/m/Y')
                    ->label('Tanggal Transaksi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('price_total')->label('Total Harga')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return '';
                        }
                
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                    })->searchable(),
                TextColumn::make('customer_email')->label('Email Kostumer')->searchable(),
                TextColumn::make('cashier_email')->label('Email Kasir')->searchable(),
                TextColumn::make('created_at')->label('Dibuat Pada'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TransactionDetailRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            // 'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
            'view' => Pages\ViewTransaction::route('/{record}'),
        ];
    }
}
