<?php

use App\Enums\TransactionStatus;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignUuid('buyer_id')->constrained('buyers')->cascadeOnDelete();
            $table->foreignUuid('seller_id')->constrained('sellers')->cascadeOnDelete();
            $table->enum('status', TransactionStatus::getToArray())->default(TransactionStatus::NEW_REQUEST->value);;
            $table->foreignUuid('file_pendukung_id')->nullable()->constrained('files')->nullOnDelete();
            $table->double('total_harga');
            $table->foreignUuid('contract_id')->nullable()->constrained('contracts')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};