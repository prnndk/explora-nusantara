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
        Schema::create('sellers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name')->unique()->index();
            $table->char('nik', 16)->unique()->index();
            $table->string('email')->unique();
            $table->string('phone_number', 15)->unique();
            $table->string('address');
            $table->foreignUuid('photo_file_id')->nullable()->constrained('files')->nullOnDelete();
            $table->foreignUuid('ktp_file_id')->nullable()->constrained('files')->nullOnDelete();
            $table->string('company_name');
            $table->string('company_address');
            $table->string('company_phone_number', 15)->unique();
            $table->string('npwp', 16)->unique()->index();
            $table->char('nib', 13)->unique();
            $table->string('bank_name');
            $table->string('bank_account_number', 30)->unique();
            $table->foreignUuid('recommendation_letter_file_id')->nullable()->constrained('files')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
