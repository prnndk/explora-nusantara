<?php

use App\Enums\ProductStatus;
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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('deskripsi');
            $table->double('harga');
            $table->integer('terjual');
            $table->integer('stok');
            $table->enum('status', ProductStatus::getToArray())->default(ProductStatus::NEW_REQUEST->value);
            $table->foreignUuid('foto_file_id')->nullable()->constrained('files')->nullOnDelete();
            $table->foreignUuid('seller_id')->nullable()->constrained('sellers')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};