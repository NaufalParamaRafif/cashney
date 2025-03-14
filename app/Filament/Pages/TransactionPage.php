<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\Category;
use Filament\Pages\Page;

class TransactionPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.transaction-page';

    public $categories;
    public $products;

    public function mount()
    {
        // Fetch categories and products
        $this->categories = Category::all();
        $this->products = Product::all();
    }

    // Pass data to the view
    protected function getViewData(): array
    {
        return [
            'categories' => $this->categories,
            'products' => $this->products,
        ];
    }
}