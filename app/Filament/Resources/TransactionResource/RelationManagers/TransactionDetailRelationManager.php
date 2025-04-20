<?php

namespace App\Filament\Resources\TransactionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use function Filament\Support\format_money;

class TransactionDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions_detail';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('product_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_name')
            ->columns([
                TextColumn::make('transaction_code')
                    ->label('Kode Transaksi')->searchable(),
                TextColumn::make('product_name')
                    ->label('Nama Produk')->searchable(),
                TextColumn::make('product_total')
                    ->label('Total Produk')->searchable(),
                TextColumn::make('price_per_item')
                    ->label('Harga perbarang')
                    ->formatStateUsing(function ($state) {
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                    })->searchable(),
                TextColumn::make('subtotal')
                    ->formatStateUsing(function ($state) {
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                    })
                    ->label('Subtotal')->searchable(),
                TextColumn::make('discount_code')
                    ->label('Kode Diskon')->searchable(),
                TextColumn::make('cashback')
                    ->formatStateUsing(function ($state) {
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                    })
                    ->label('Cashback')->searchable(),
                TextColumn::make('free_product_total')->label('Produk gratis')->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
