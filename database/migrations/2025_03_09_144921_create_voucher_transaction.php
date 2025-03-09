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
        Schema::create('voucher_transaction', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_code');
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->unsignedBigInteger('transaction_id');
            
            $table->timestamps();
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_transaction');
    }
};
