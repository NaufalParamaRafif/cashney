<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Transaction;
use App\Models\TransactionDetail;
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
use Illuminate\Support\Facades\DB;


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
                $customer = Customer::find($data['customer_id'] ?? null);
                $items = $arguments['items'] ?? [];
            
                $productIds = collect($items)->pluck('item_id')->all();
                $products = Product::with('discount')->whereIn('id', $productIds)->get()->keyBy('id');
            
                DB::beginTransaction();
            
                try {
                    $transaction = Transaction::create([
                        'price_total' => 0,
                        'customer_id' => $customer->id ?? null,
                        'cashier_id' => auth()->user()->id,
                        'customer_email' => $customer->email ?? null,
                        'cashier_email' => auth()->user()->email,
                    ]);
            
                    $transactionDetails = [];
            
                    foreach ($items as $item) {
                        $productId = $item['item_id'];
                        $quantity = $item['item_quantity'] ?? 1;
                        $freeQty = $item['free_quantity'] ?? 0;
            
                        $product = $products[$productId];
                        $price = $product->price;
                        $discount = $product->discount ?? null;
            
                        if ($customer && $customer->is_member && $discount && $this->isEligible($discount, $customer, $product)) {
                            $price = $this->applyDiscount($discount, $price);
                        }
            
                        $transactionDetails[] = [
                            'transaction_id' => $transaction->id,
                            'product_id' => $product->id,
                            'discount_id' => $discount->id ?? null,
                            'transaction_code' => $transaction->code,
                            'product_name' => $product->name,
                            'discount_code' => $discount->code ?? null,
            
                            'product_total' => $quantity,
                            'free_product_total' => $freeQty,
                            'cashback' => $discount->cashback ?? 0,
                            'price_per_item' => $price,
                            'subtotal' => ($quantity * $price),
                        ];
                    }
            
                    TransactionDetail::insert($transactionDetails);
            
                    // Update total price
                    $transaction->update([
                        'price_total' => collect($transactionDetails)->sum('subtotal'),
                    ]);
            
                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    throw $th;
                }
            });
                   
            // ->action(function (array $data, array $arguments): void {
            //     dd($data, $arguments); // <--- Test Output
            //     // kalo customer gak ada member
            //         // buat data transaction
            //         // buat data transaction detail

            //     // kalo ada
            //     // iterate each products
            //         // layak = discount.max_used - discount.used !== 0 && discount.minimum_purchase_price == 0 && discount.minimum_point == 0
            //         // cek apakah ada diskon nominal dan layak
            //         // cek apakah ada diskon persentase dan layak
            //         // cek apakah ada diskon paket dan layak
            //         // cek apakah ada diskon cashback dan layak
            //         // cek apakah ada diskon voucher dan layak
            //         // mungkin kamu bisa membuat array sebelumnya agar item saat ini bisa disempan ke array itu dan semua item dalam array bisa langsung bisa ditambahkan ke transaction detail
            //     // buat data transaction
            //     // buat data transaction detail
            // });
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

    protected function isEligible(Discount $discount, Customer $customer, Product $product)
    {
        if ($discount->max_used && $discount->used >= $discount->max_used) {
            return false;
        }

        if ($discount->minimum_purchase_price && $product->price < $discount->minimum_purchase_price) {
            return false;
        }

        if ($discount->minimum_point && $customer->point < $discount->minimum_point) {
            return false;
        }

        return true;
    }

    protected function applyDiscount(Discount $discount, float $price)
    {
        if ($discount->type === 'nominal') {
            return max(0, $price - $discount->amount);
        }

        if ($discount->type === 'persentase') {
            return max(0, $price * ((100 - $discount->percentage) / 100));
        }

        return $price;
    }
}