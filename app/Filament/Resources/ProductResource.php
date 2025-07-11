<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use function Filament\Support\format_money;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use App\Models\Discount;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'super_admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Nama')
                    ->minLength(3)
                    ->maxLength(80),
                TextInput::make('price')
                    ->required()
                    ->label('Harga')
                    ->numeric()
                    ->inputMode('numeric')
                    ->prefix('Rp.'),
                FileUpload::make('image')
                    ->label('Gambar')
                    ->required()
                    ->image()
                    ->imageEditor(),
                Select::make('discount_id')
                    ->label('Diskon')
                    ->options(function () {
                        return Discount::all()->mapWithKeys(function ($discount) {
                            $label = view('components.discount-option', ['discount' => $discount])->render();
                            return [$discount->id => $label];
                        });
                    })
                    ->searchable()
                    ->allowHtml(),
                TextInput::make('supply')
                    ->required()
                    ->label('Stok')
                    ->numeric()
                    ->inputMode('numeric')
                    ->minValue(0)
                    ->maxValue(10000),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable(),
                ImageColumn::make('image')->label('Gambar'),
                TextColumn::make('price')->label('Harga')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return '';
                        }
                
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                    })
                    ->searchable(),
                TextColumn::make('supply')->label('Jumlah')->searchable(),
                TextColumn::make('created_at')->label('Dibuat Pada'),
                TextColumn::make('updated_at')->label('Diubah Pada')
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
