<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Discount;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Forms\Set;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Get;

class TransactionPage extends Page implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.transaction-page';

    public $categories;
    public $products;

    public function checkoutAction(): Action
    {
        return Action::make('checkout')
            ->form([
                Select::make('member_code')
                    ->label('Kode Member')
                    ->options(Customer::all()->pluck('member_code', 'member_code'))
                    ->searchable(),
                TextInput::make('voucher_code')
                ->label('Kode Voucher')
                ->length(9)
                ->suffixAction(
                    FormAction::make('applyVoucher')
                        ->icon('heroicon-m-check')
                        ->tooltip('Apply Voucher')
                        ->color('success')
                        ->action(function (Set $set, Get $get, $state) {
                            if (!Discount::where('code', $state)->exists()) {
                                $set('voucher_error', 'Voucher tidak ditemukan!');
                                $set('voucher_code', null);
                            } else {
                                $set('voucher_error', 'Voucher tersedia');
                            }
                        })
                )
                ->hint(fn (Get $get) => $get('voucher_error'))
                ->hintColor(fn (Get $get) => $get('voucher_error') === 'Voucher tersedia' ? 'success' : 'danger')
            ])
            ->action(function (array $data, array $arguments): void {
                dd($data, $arguments); // <--- Test Output
                // kalo customer gak ada member
                    // buat data transaction
                    // buat data transaction detail

                // kalo ada
                // iterate each products
                    // layak = discount.max_used - discount.used !== 0 && discount.minimum_purchase_price == 0 && discount.minimum_point == 0
                    // cek apakah ada diskon nominal dan layak
                    // cek apakah ada diskon persentase dan layak
                    // cek apakah ada diskon paket dan layak
                    // cek apakah ada diskon cashback dan layak
                    // cek apakah ada diskon voucher dan layak
                    // mungkin kamu bisa membuat array sebelumnya agar item saat ini bisa disempan ke array itu dan semua item dalam array bisa langsung bisa ditambahkan ke transaction detail
                // buat data transaction
                // buat data transaction detail
            });
    }
    
    public function mount()
    {
        $this->categories = Category::all();
        $this->products = Product::all();
    }

    protected function getViewData(): array
    {
        return [
            'categories' => $this->categories,
            'products' => $this->products,
        ];
    }
}