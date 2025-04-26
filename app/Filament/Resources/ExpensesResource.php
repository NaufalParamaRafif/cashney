<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpensesResource\Pages;
use App\Filament\Resources\ExpensesResource\RelationManagers;
use App\Models\Expenses;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Product;
use Filament\Tables\Columns\TextColumn;

class ExpensesResource extends Resource
{
    protected static ?string $model = Expenses::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    // Section Informasi Produk
                Forms\Components\Section::make('Informasi Produk')
                ->schema([
                    Forms\Components\Select::make('product_id')
                        ->label('Pilih Produk')
                        ->required()
                        ->options(Product::query()->orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->live()
                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                            if ($state) {
                                $product = Product::find($state);
                                $set('product_name', $product->name);
                                $set('current_stock', $product->supply);
                            }
                        }),
                    
                    Forms\Components\Hidden::make('product_name')
                        ->label('Nama Produk')
                        ->disabled()
                        ->dehydrated(),
                    
                    Forms\Components\TextInput::make('current_stock')
                        ->label('Stok Saat Ini')
                        ->numeric()
                        ->disabled()
                        ->dehydrated(false),
                ])
                ->columns(3),
            
                // Section Penambahan Stok
                Forms\Components\Section::make('Penambahan Stok')
                    ->schema([
                        Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah Penambahan')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                $currentStock = $get('current_stock') ?? 0;
                                $set('new_stock', $currentStock + $state);
                            }),
                        
                        Forms\Components\TextInput::make('new_stock')
                            ->label('Stok Setelah Penambahan')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(false),
                    ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_name')->label('Nama Produk')->searchable(),
                TextColumn::make('quantity')->label('Penambahan')->searchable(),
                TextColumn::make('created_at')->label('Diubah pada')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpenses::route('/create'),
            'edit' => Pages\EditExpenses::route('/{record}/edit'),
        ];
    }
}
