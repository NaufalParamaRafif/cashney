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

class DiscountResource extends Resource
{
    protected static ?string $model = Discount::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->minLength(4)
                    ->maxLength(25),
                TextInput::make('max_used')
                    ->numeric()
                    ->inputMode('numeric')
                    ->minValue(1)
                    ->maxValue(10000),
                TextInput::make('discount_percentage')
                    ->numeric()
                    ->inputMode('decimal')
                    ->minValue(0)
                    ->maxValue(100),
                DatePicker::make('expired_date')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->label('Kode')->searchable(),
                TextColumn::make('max_used')->label('Maksimal Pengguna')->searchable(),
                TextColumn::make('discount_percentage')->label('Diskon(%)')->searchable(),
                TextColumn::make('used')->label('Digunakan (×)')->searchable(),
                TextColumn::make('minimum_point')->label('Poin Minimum')->searchable(),
                TextColumn::make('expired_date')->label('Berakhir Pada'),
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
