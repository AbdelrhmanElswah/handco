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
            $table->unsignedInteger('bedrooms')->nullable(); // Number of bedrooms
            $table->unsignedInteger('bathrooms')->nullable(); // Number of bathrooms
            $table->unsignedInteger('parking_spaces')->nullable(); // Number of parking spaces
            $table->boolean('swimming_pool')->default(false); // Has swimming pool or not
            $table->boolean('gym')->default(false); // Has gym or not
            $table->boolean('garden')->default(false); // Has garden or not
            $table->boolean('air_conditioning')->default(false); // Has air conditioning
            $table->boolean('furnished')->default(false); // Is furnished or not
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
