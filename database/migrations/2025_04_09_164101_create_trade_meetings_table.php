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
        Schema::create('trade_meetings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('zoom_id')->unique();
            $table->string('buyer_id')->nullable()->constrained('buyers')->nullOnDelete();
            $table->string('seller_id')->nullable()->constrained('sellers')->nullOnDelete();
            $table->string('password');
            $table->string('topic');
            $table->datetime('start_time');
            $table->string('duration');
            $table->enum('status', ProductStatus::getToArray())->default(ProductStatus::NEW_REQUEST->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_meetings');
    }
};