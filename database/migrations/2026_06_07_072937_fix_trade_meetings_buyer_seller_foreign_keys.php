<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * `buyer_id`/`seller_id` were created as plain `string` columns with `->constrained()`,
     * which silently no-ops on non-foreignId columns — leaving them as untyped varchar(255)
     * with no FK constraint and no index, while `buyers.id`/`sellers.id` are `uuid`.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE trade_meetings ALTER COLUMN buyer_id TYPE uuid USING buyer_id::uuid');
        DB::statement('ALTER TABLE trade_meetings ALTER COLUMN seller_id TYPE uuid USING seller_id::uuid');

        Schema::table('trade_meetings', function (Blueprint $table) {
            $table->foreign('buyer_id')->references('id')->on('buyers')->nullOnDelete();
            $table->foreign('seller_id')->references('id')->on('sellers')->nullOnDelete();
            $table->index('buyer_id');
            $table->index('seller_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trade_meetings', function (Blueprint $table) {
            $table->dropForeign(['buyer_id']);
            $table->dropForeign(['seller_id']);
            $table->dropIndex(['buyer_id']);
            $table->dropIndex(['seller_id']);
        });

        DB::statement('ALTER TABLE trade_meetings ALTER COLUMN buyer_id TYPE varchar(255) USING buyer_id::varchar');
        DB::statement('ALTER TABLE trade_meetings ALTER COLUMN seller_id TYPE varchar(255) USING seller_id::varchar');
    }
};
