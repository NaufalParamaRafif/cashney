<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    public function vouchers(): BelongsToMany
    {
        return $this->belongsToMany(Voucher::class);
    }

    public function transactions_detail(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
