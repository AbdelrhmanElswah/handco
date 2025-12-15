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
        Schema::table('bookings', function (Blueprint $table) {
            // Add off_plan_project_id column
            $table->unsignedBigInteger('off_plan_project_id')->nullable()->after('project_id');
            
            // Add foreign key for off_plan_projects
            $table->foreign('off_plan_project_id')->references('id')->on('off_plan_projects')->onDelete('cascade');
        });
        
        // Make project_id nullable using raw SQL
        DB::statement('ALTER TABLE `bookings` MODIFY `project_id` BIGINT UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['off_plan_project_id']);
            
            // Drop column
            $table->dropColumn('off_plan_project_id');
        });
        
        // Revert project_id to not nullable using raw SQL
        DB::statement('ALTER TABLE `bookings` MODIFY `project_id` BIGINT UNSIGNED NOT NULL');
    }
};
