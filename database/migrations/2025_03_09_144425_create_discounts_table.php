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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', length: 9)->unique();
            $table->unsignedInteger('max_used');
            $table->unsignedInteger('used')->default(0);
            $table->unsignedInteger('minimum_point')->default(0);
            $table->decimal('minimum_purchase_price', $precision = 10, $scale = 2)->default(0);
            $table->enum('categories', ['nominal', 'persentase', 'paket', 'cashback']);
            $table->decimal('nominal_discount', $precision = 9, $scale = 2)->nullable();
            $table->decimal('cashback_discount', $precision = 9, $scale = 2)->nullable();
            $table->decimal('persentase_harga_discount', $precision = 4, $scale = 2)->nullable();
            $table->unsignedTinyInteger('minimum_buy_discount')->nullable();
            $table->unsignedTinyInteger('get_discount')->nullable();
            $table->date('start_date');
            $table->date('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
