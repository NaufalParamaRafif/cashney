<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'transactions_detail';

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

        public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
