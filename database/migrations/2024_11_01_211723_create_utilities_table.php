<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilities', function (Blueprint $table) {
            $table->id();
            $table->integer('bedrooms')->unsigned()->nullable();
            $table->integer('bathrooms')->unsigned()->nullable();
            $table->integer('parking_spaces')->unsigned()->nullable();
            $table->boolean('swimming_pool')->default(false);
            $table->boolean('gym')->default(false);
            $table->boolean('garden')->default(false);
            $table->boolean('air_conditioning')->default(false);
            $table->boolean('furnished')->default(false);
            $table->boolean('balcony')->default(false);
            $table->boolean('view_of_landmarks')->default(false);
            $table->boolean('built_in_wardrobes')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utilities');
    }
}
