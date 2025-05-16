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
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('durasi')->after('product_id')->nullable();
            $table->integer('kuantitas_pembelian')->after('durasi')->nullable();
            $table->double('subtotal_produk')->after('kuantitas_pembelian')->nullable();
            $table->double('subtotal_shipping')->after('subtotal_produk')->nullable();
            $table->double('subtotal_asuransi')->after('subtotal_shipping')->nullable();
            $table->double('subtotal_service')->after('subtotal_asuransi')->nullable();
            $table->double('total')->after('subtotal_service')->nullable();
            $table->string('payment_method')->after('total')->nullable();
            $table->string('pengiriman')->after('payment_method')->nullable();
            $table->string('note_to_seller')->after('pengiriman')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
