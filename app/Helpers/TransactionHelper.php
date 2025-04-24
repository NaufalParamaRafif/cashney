<?php

namespace App\Helpers;

use App\Models\Customer;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Support\Carbon;

class TransactionHelper
{
    public static function isEligible(Discount $discount, Customer $customer, Product $product): bool
    {
        return
            ($discount->max_used === null || $discount->used < $discount->max_used) &&
            $discount->minimum_purchase_price <= $product->price &&
            $discount->minimum_point <= ($customer->point ?? 0) &&
            (
                $discount->end_date === null ||
                Carbon::now()->lessThanOrEqualTo($discount->end_date)
            );;
    }

    public static function applyDiscount(Discount $discount, float $price): float
    {
        if ($discount->categories === 'nominal') {
            return max($price - $discount->nominal_discount, 0);
        }

        if ($discount->categories === 'persentase') {
            return max($price - ($price * $discount->persentase_harga_discount / 100), 0);
        }

        return $price;
    }

    public static function calculateFreeQty(Discount $discount, int $quantity): int
    {
        if ($discount->categories === 'paket' && $discount->minimum_buy_discount > 0 && $discount->get_discount > 0) {
            return $discount->get_discount;
        }

        return 0;
    }
}
