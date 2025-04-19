<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_total');
            $table->unsignedInteger('free_product_total')->default(0);
            $table->unsignedInteger('cashback')->default(0);
            $table->decimal('price_per_item', $precision = 9, $scale = 2);
            $table->decimal('subtotal', $precision = 10, $scale = 2);
            $table->string('transaction_code');
            $table->string('product_name');
            $table->string('discount_code')->nullable();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('discount_id')->nullable();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions_detail');
    }
};
