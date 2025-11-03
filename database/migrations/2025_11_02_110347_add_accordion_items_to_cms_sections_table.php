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
            $table->json('accordion_items')->nullable()->after('testimonials'); // For accordion/FAQ items with title and content
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
            $table->dropColumn('accordion_items');
        });
    }
};
