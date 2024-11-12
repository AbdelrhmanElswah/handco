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
        Schema::table('utilities', function (Blueprint $table) {
            $table->boolean('garage_facility')->default(0);
            $table->boolean('fire_security')->default(0);
            $table->boolean('fire_place_facility')->default(0);
            $table->boolean('play_ground')->default(0);
            $table->boolean('furniture_include')->default(0);
            $table->boolean('marble_floor')->default(0);
            $table->boolean('store_room')->default(0);
            $table->boolean('high_class_door')->default(0);
            $table->boolean('floor_heating_system')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('utilities', function (Blueprint $table) {
            //
        });
    }
};
