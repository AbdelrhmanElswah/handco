<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cms_sections', function (Blueprint $table) {
            $table->json('testimonials')->nullable()->after('stats_items'); // For testimonials with quote, author, and position
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cms_sections', function (Blueprint $table) {
            $table->dropColumn('testimonials');
        });
    }
};
