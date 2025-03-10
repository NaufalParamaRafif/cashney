<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model
{
    use HasFactory;

    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
