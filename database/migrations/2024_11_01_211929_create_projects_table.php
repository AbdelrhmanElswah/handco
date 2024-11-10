<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 10, 2); // Price with two decimal places
            $table->unsignedBigInteger('category_id'); // Foreign key for category
            $table->string('title'); // Project title
            $table->string('location_name'); // Location to link to Google Maps
            $table->string('location_link')->nullable(); // Location to link to Google Maps
            $table->json('tags')->nullable(); // Array of tags as JSON
            $table->text('description')->nullable(); // Description of the project
            $table->unsignedBigInteger('utilities_id'); // Foreign key for utilities
            $table->unsignedInteger('floor_area')->nullable();
            $table->timestamps();

            // Define foreign key constraints if the related tables exist
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('utilities_id')->references('id')->on('utilities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
