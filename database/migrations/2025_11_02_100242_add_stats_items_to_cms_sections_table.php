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
            $table->json('stats_items')->nullable()->after('list_items'); // For statistics with value and description
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
            $table->dropColumn('stats_items');
        });
    }
};
