<?php

use Illuminate\Database\Migrations\Migration;
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
        // Change starting_price column from decimal to varchar(255) using raw SQL
        DB::statement('ALTER TABLE `off_plan_projects` MODIFY `starting_price` VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert back to decimal type
        DB::statement('ALTER TABLE `off_plan_projects` MODIFY `starting_price` DECIMAL(15, 2) NULL');
    }
};
