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
            $table->decimal('subtotal', $precision = 10, $scale = 2);
            $table->string('product_name');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('transaction_id');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
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
