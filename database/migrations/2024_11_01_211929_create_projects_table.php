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
            $table->decimal('price', 10, 2);
            $table->string('rent_or_service')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('title');
            $table->string('location_name')->nullable();
            $table->string('location_link')->nullable();
            $table->json('tags')->nullable();
            $table->text('description')->nullable();
            $table->string('payment_option')->nullable();
            $table->unsignedBigInteger('utilities_id');
            $table->integer('floor_area')->unsigned()->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
            $table->string('status')->default('available');
            $table->json('selling_points')->nullable();
            $table->json('more_information')->nullable();

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
