<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop the foreign key constraint first
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        // Modify the column to be nullable using raw SQL
        DB::statement('ALTER TABLE `blogs` MODIFY `category_id` BIGINT UNSIGNED NULL');

        // Re-add the foreign key constraint
        Schema::table('blogs', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the foreign key constraint
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        // Make the column not nullable again using raw SQL
        DB::statement('ALTER TABLE `blogs` MODIFY `category_id` BIGINT UNSIGNED NOT NULL');

        // Re-add the foreign key constraint
        Schema::table('blogs', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }
};
