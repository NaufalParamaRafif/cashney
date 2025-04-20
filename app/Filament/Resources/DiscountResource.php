<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiscountResource\Pages;
use App\Filament\Resources\DiscountResource\RelationManagers;
use App\Models\Discount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;

class DiscountResource extends Resource
{
    protected static ?string $model = Discount::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->readOnly()
                    ->minLength(5),
                TextInput::make('code')
                    ->label('Kode')
                    ->minLength(4)
                    ->maxLength(25),
                TextInput::make('max_used')
                    ->label('Maksimal Pengguna')
                    ->numeric()
                    ->inputMode('numeric')
                    ->minValue(1)
                    ->maxValue(1000000),
                TextInput::make('minimum_point')
                    ->label('Poin Minimal')
                    ->numeric()
                    ->inputMode('numeric'),
                TextInput::make('minimum_purchase_price')
                    ->label('Harga Minimal Pembelian')
                    ->numeric()
                    ->inputMode('numeric'),
                Select::make('categories')
                    ->label('Kategori')
                    ->live()
                    ->options([
                        'nominal'       => 'Nominal Harga',
                        'persentase'    => 'Persentase Harga',
                        'paket'         => 'Paket',
                        'cashback'      => 'Cashback',
                    ])
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('nominal_discount', null);
                        $set('persentase_harga_discount', null);
                        $set('minimum_buy_discount', null);
                        $set('get_discount', null);
                        $set('cashback_discount', null);
                    }),
                TextInput::make('nominal_discount')
                    ->reactive()
                    ->numeric()
                    ->prefix('Rp')
                    ->inputMode('numeric')
                    ->required(fn (Get $get): bool => $get('categories') == 'nominal')
                    ->visible(fn (Get $get): bool => $get('categories') == 'nominal'),
                TextInput::make('persentase_harga_discount')
                    ->reactive()
                    ->numeric()
                    ->suffix('%')
                    ->inputMode('numeric')
                    ->required(fn (Get $get): bool => $get('categories') == 'persentase')
                    ->visible(fn (Get $get): bool => $get('categories') == 'persentase'),
                TextInput::make('minimum_buy_discount')
                    ->reactive()
                    ->numeric()
                    ->inputMode('numeric')
                    ->prefix('beli')
                    ->required(fn (Get $get): bool => $get('categories') == 'paket')
                    ->visible(fn (Get $get): bool => $get('categories') == 'paket'),
                TextInput::make('get_discount')
                    ->reactive()
                    ->numeric()
                    ->inputMode('numeric')
                    ->prefix('gratis')
                    ->required(fn (Get $get): bool => $get('categories') == 'paket')
                    ->visible(fn (Get $get): bool => $get('categories') == 'paket'),
                TextInput::make('cashback_discount')
                    ->reactive()
                    ->numeric()
                    ->inputMode('numeric')
                    ->prefix('Rp')
                    ->required(fn (Get $get): bool => $get('categories') == 'cashback')
                    ->visible(fn (Get $get): bool => $get('categories') == 'cashback'),
                DatePicker::make('start_date')
                    ->label('Dimulai pada'),
                DatePicker::make('end_date')
                    ->label('Berakhir pada'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->label('Kode')->searchable(),
                TextColumn::make('max_used')->label('Maksimal Pengguna')->searchable(),
                TextColumn::make('used')->label('Digunakan (×)')->searchable(),
                TextColumn::make('minimum_point')->label('Poin Minimum')->searchable(),
                TextColumn::make('start_date')->label('Dimulai Pada'),
                TextColumn::make('end_date')->label('Berakhir Pada'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
        ];
    }
}
