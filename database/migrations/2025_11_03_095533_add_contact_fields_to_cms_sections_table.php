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
            $table->json('contact_phones')->nullable()->after('accordion_items');
            $table->json('contact_addresses')->nullable()->after('contact_phones');
            $table->json('contact_emails')->nullable()->after('contact_addresses');
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
            $table->dropColumn(['contact_phones', 'contact_addresses', 'contact_emails']);
        });
    }
};
