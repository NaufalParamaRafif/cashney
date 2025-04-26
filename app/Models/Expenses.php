<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Expenses extends Model
{
    use HasFactory;

    // Model Expense
    protected static function booted()
    {
        static::created(function ($expense) {
            if ($expense->product_id) {
                Product::where('id', $expense->product_id)
                    ->increment('supply', $expense->quantity);
            }
        });
    }
}
