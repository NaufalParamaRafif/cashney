<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->minLength(3)
                    ->maxLength(80),
                Textarea::make('address')
                    ->label('Alamat')
                    ->minLength(3)
                    ->maxLength(255),
                Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Pria' => 'Pria',
                        'Wanita' => 'Wanita',
                    ]),
                DatePicker::make('birth_date')
                    ->label('Tanggal Lahir'),
                TextInput::make('point')
                    ->label('Point')
                    ->readOnly(),
                TextInput::make('email')
                    ->label('Email'),
                TextInput::make('phone_number')->tel()
                    ->label('Nomor Telephone')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable(),
                TextColumn::make('address')->label('Alamat')->searchable(),
                TextColumn::make('point')->label('Poin')->searchable(),
                TextColumn::make('birth_date')->label('Tanggal Lahir')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('phone_number')->label('Nomor Telephone')->searchable(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
