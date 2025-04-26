<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Helpers\TransactionHelper;
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

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'employee';
    }

    public function checkoutAction(): Action
    {
        return Action::make('checkout')
            ->form([
                Select::make('member_code')
                    ->label('Kode Member')
                    ->options(Customer::all()->pluck('member_code', 'member_code'))
                    ->searchable(),
            ])
            ->action(function (array $data, array $arguments): void {
                $customer = Customer::find($data['member_code'] ?? null);
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
                        $quantity = $item['item_quantity'];
                        
                        $freeQty = 0;
                        $product = $products[$productId];
                        $price = $product->price;
                        $discount = $product->discount ?? null;

                        if (
                            $customer && $discount &&
                            TransactionHelper::isEligible($discount, $customer, $product)
                        ) {
                            $price = TransactionHelper::applyDiscount($discount, $price);
                            $freeQty = TransactionHelper::calculateFreeQty($discount, $quantity);
            
                            if ($discount->minimum_point > 0 && $customer->point >= $discount->minimum_point) {
                                $customer->decrement('point', ($discount->minimum_point * 0.025));
                            }
            
                            if ($discount->max_used !== null) {
                                $discount->increment('used');
                            }
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
                            'cashback' => $discount->cashback_discount ?? 0,
                            'price_per_item' => $price,
                            'subtotal' => $price * $quantity,
                        ];
            
                        $product->decrement('supply', $quantity);
                    }
            
                    TransactionDetail::insert($transactionDetails);
            
                    $transaction->update([
                        'price_total' => collect($transactionDetails)->sum('subtotal'),
                        'cashback' => collect($transactionDetails)->sum('cashback'),
                    ]);
            
                    // Tambahkan point reward untuk member (misal: 1 poin per 10rb)
                    if ($customer) {
                        $customer->increment('point', floor($transaction->price_total / 10000));
                    }
            
                    Notification::make()
                        ->title('Transaksi berhasil')
                        ->success()
                        ->body('Klik tombol di bawah untuk mencetak kwitansi.')
                        ->actions([
                            \Filament\Notifications\Actions\Action::make('print')
                                ->label('Cetak Kwitansi')
                                ->url(route('receipt.print', $transaction->id))
                                ->openUrlInNewTab(),
                        ])
                        ->send();

                    DB::commit();
                    
                    $this->dispatch('transaction-finished');
                } catch (\Throwable $th) {
                    DB::rollBack();
                    throw $th;
                }
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